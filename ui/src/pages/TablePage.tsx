import React, { useState} from "react";
import SearchField from "../components/SearchField";
import fs from "./CompanyStyle.module.css";
import {pr} from "../common/utils";
import TableNew, {ColumnI, SearchTParamsI} from "../components/Tablen/TableNew";
import ls from '../components/styles/linksStyle.module.css'
import {requestResult} from "../common/api";
import {getHistoricalQuotes} from "../queries/historicalQuotes";

export interface SearchI {
    search: string | null,
    perPage: 10 | 30 | 50,
    page: number,
    pages: number,
    order: 'asc' | 'desc',
    orderBy: string | null,
}



export interface StateI {
    search: string,
    searchButton: boolean
}



export default function TablePage() {


    const [state, setState] = useState<StateI>({
        search: '',
        searchButton: false
    });


    const searchHistoricalQuotes = (params: SearchTParamsI): Promise<requestResult> => {
        const {search} = state
        return getHistoricalQuotes({...params, search});
    }

    const handleChange = (field: string) => (e: any) => {
        let value = e.target.value ?? e;
        setState(prev => ({
            ...prev,
            [field]: value
        }))
    }


    const handleSearch = () => {
        setState(prev => ({
            ...prev,
            searchButton: !prev.searchButton
        }))
    }


    const columnsTypes: ColumnI[] = [
        {id: 'date', text: 'Date'},
        {id: 'open', text: 'Open'},
        {id: 'high', text: 'High'},
        {id: 'low', text: 'Low'},
        {id: 'close', text: 'Close'},
        {id: 'volume', text: 'Volume'},
    ]
// Date | Open | High | Low | Close | Volume


    const {searchButton, search} = state
    return (
        <div>
            <h3 className={ls.linkGroup}> Table Page </h3>
            <div className={fs.search}>
                <SearchField onSubmit={handleSearch} onChange={handleChange('search')} value={search}/>
                <TableNew getTableData={searchHistoricalQuotes}
                          columnsTypes={columnsTypes} searchButton={searchButton}/>
            </div>


        </div>
    )
}