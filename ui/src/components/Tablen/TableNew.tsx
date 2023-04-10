import React, {useEffect, useState} from "react";
import TableHeaderN from "./TableHeaderN";
import {SearchI} from "../../pages/TablePage";
import TableRowN from "./TableRowN";
import g from '../parts/general.module.css';
import ts from "../styles/tableStyle.module.css";
import TablePaginate from "../parts/TablePaginate";
import {pr} from "../../common/utils";
import {requestResult} from "../../common/api";

export interface ColumnI {
    id: string,
    text: string,
    type?: 'change' | 'date',
    onClick?: (field: string, rowId: number) => (e: any) => void
}
export interface SearchTableI extends Omit<SearchI, 'search'> {
    tableData: any[],
    refreshLocal: boolean,
    rows: number
}

export interface SearchTParamsI {
    perPage: 10 | 30 | 50,
    page: number,
    order: 'asc' | 'desc',
    orderBy: string | null,
}

export interface propsI {
    getTableData: (params: SearchTParamsI) => Promise<requestResult>,
    columnsTypes: ColumnI[],
    searchButton: boolean,
    search?: string | null
}


export default function TableNew(props: propsI) {
    const {getTableData, columnsTypes, searchButton} = props

    const [state, setState] = useState<SearchTableI>({
        page: 1,
        pages: 1,
        perPage: 10,
        order: 'asc',
        orderBy: columnsTypes[0].id,
        rows: 0,
        tableData: [],
        refreshLocal: false
    })

    useEffect(() => {
        getDataTable();
    }, [ state.refreshLocal])

    useEffect(() => {
        handleChange('page', 1, false)
        refreshAction();
    }, [searchButton])


    const getDataTable = () => {
        const {perPage, page, orderBy, order} = state

        let params = {
            perPage,
            page,
            order,
            orderBy
        }
        getTableData(params).then(response => {
                pr(response);
                setState(prev => ({
                    ...prev,
                    tableData: response.data,
                    ...response.pagination

                }))
            }
        );

    }


    const refreshAction = () => {
        setState(prev => ({
            ...prev,
            refreshLocal: !prev.refreshLocal
        }))
    }

    const handleChange = (field: string, value: any, isRefresh: boolean = true) => {
        switch (field) {
            case 'perPage':
                let selection = (page - 1) * value;
                if (state.rows < selection)
                    handleChange('page', 1, false)
                break;
        }
        setState(prev => ({
            ...prev,
            [field]: value
        }));

        if (isRefresh)
            refreshAction();
    }


    const orderByColumn = (orderBy: string) => () => {

        setState(prev => ({
                ...prev,
                orderBy: orderBy,
                order: prev.order === 'asc' ? 'desc' : 'asc'
            })
        )
        refreshAction();
    }

    const {page, perPage, pages, orderBy, order, tableData} = state

    return (
        <div className={ts.box}>

            <div className={g.tableScroll}>
                <table className={g.tableBeauty}>
                    <thead>
                    <TableHeaderN columnsTypes={columnsTypes} orderByColumn={orderByColumn} order={order}
                                  orderBy={orderBy}/>
                    </thead>
                    <tbody>
                    {tableData.map((row: any, idx) => {
                        return <TableRowN id={idx} values={row}
                                          columnTypes={columnsTypes}/>
                    })}
                    </tbody>
                </table>
            </div>
            <TablePaginate onChange={handleChange} page={page} pages={pages} perPage={perPage}/>
        </div>
    )
}