import React, {useEffect, useState} from "react";

import {Autocomplete, Button, Input, TextField} from "@mui/material";
import {DatePicker as DatePickerM} from "@mui/x-date-pickers";
import DatePicker from "react-datepicker";
import {pr} from "../common/utils";
import EmailField from "../components/form/EmailField";
import bs from './baseStyle.module.css';
import 'react-datepicker/dist/react-datepicker.css';
import {DateRangePicker} from "@react-spectrum/datepicker";
// import { DateRangePicker } from 'react-date-range';
import {DateRange} from "@mui/x-date-pickers/internals/components/icons";
import DatePickerRange from "../components/form/DatePickerRange";
import TextInput from "../components/form/TextInput";
import TableNew, {ColumnI} from "../components/Tablen/TableNew";
import TableStatic from "../components/Tablen/TableStatic";
import {getCompaniesLike, getCompaniesNameAndSymbol, getHistoricalQuotes} from "../queries/historicalQuotes";
import LineChart from "../components/LineChart";
import SearchField from "../components/form/SearchField";

interface PropsI {
    popup: (text: any) => void

}


export default function HistoricalQuotesFormPage(props: PropsI) {

    const [state, setState] = useState({
        search: {
            companySymbol: null,
            startDate: null,
            endDate: null,
            email: null
        },
        canSubmits: {
            companySymbol: false,
            dateRange: false,
            email: false
        },
        tableData: [],
        companiesNameAndSymbols: []
    });

    useEffect(() => {
        getCompaniesLikeForSelect();
    }, [state.search.companySymbol])


    const onChangeSearch = (name: string) => (e: any) => {
        let value = e?.target?.value ?? e;
        pr(e)
        pr(value)

        setState(prev => ({
            ...prev,
            search: {
                ...prev.search,
                [name]: value
            }
        }))
    }

    const submit = () => {
        pr('dq')
        getHistoricalQuotes(state.search)
            .then(result => {
                if (result.success)
                    setState(prev => ({
                        ...prev,
                        tableData: result.data
                    }))
                else
                    props.popup(result.message)
            })
    }

    const setSubmitFunc = (name: string) => (isCanSubmit: boolean) => {
        setState(prev => ({
            ...prev,
            canSubmits: {
                ...prev.canSubmits,
                [name]: isCanSubmit
            }
        }))
    }

    const canSubmit = () => {
        const {canSubmits} = state
        const {dateRange, email, companySymbol} = canSubmits

        return dateRange && email && companySymbol;
    }

    const getCompaniesLikeForSelect = () => {
        const {search} = state
        pr('dqd')
        getCompaniesLike(search.companySymbol)
            .then(result => {
                if (result.success)
                    setState(prev => ({
                        ...prev,
                        companiesNameAndSymbols: result.data
                    }))
                else
                    props.popup(result.message)
            })
    }

    const columnsTypes: ColumnI[] = [
        {id: 'date', text: 'Date'},
        {id: 'open', text: 'Open'},
        {id: 'high', text: 'High'},
        {id: 'low', text: 'Low'},
        {id: 'close', text: 'Close'},
        {id: 'volume', text: 'Volume'},
    ]

    const {search, tableData, companiesNameAndSymbols} = state
    const {companySymbol, startDate, endDate, email} = search


    return (
        <div>
            <div  className={bs.mainContainer}>
                <div className={bs.containerSearch}>

                    <SearchField value={companySymbol} onChange={onChangeSearch('companySymbol')}
                                 options={companiesNameAndSymbols} setSubmit={setSubmitFunc('companySymbol')}/>

                    <DatePickerRange startDate={startDate} endDate={endDate} onChange={onChangeSearch}
                                     setSubmit={setSubmitFunc('dateRange')}/>
                    <EmailField value={email} onChange={onChangeSearch('email')} setSubmit={setSubmitFunc('email')}/>
                    <Button color={"secondary"} variant={"contained"} onClick={submit} disabled={!canSubmit()}>Get Data
                        table</Button>
                </div>
                <div className={bs.container}>
                    <div>
                        edwqd
                        <TableStatic tableData={tableData} columnsTypes={columnsTypes}/>
                    </div>
                    <div style={{width: 1050}}>
                        <LineChart label={'date'} data={tableData} lines={['open', 'close']}/>
                    </div>
                </div>
            </div>


        </div>
    );

}