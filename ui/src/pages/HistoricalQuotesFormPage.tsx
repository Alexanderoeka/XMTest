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


export default function HistoricalQuotesFormPage() {

    const [state, setState] = useState({
        search: {
            companySymbol: null,
            startDate: null,
            endDate: null,
            email: null
        },
        canSubmits: {
            text: false,
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
                pr(result.data)
                pr(result.data[230])
                if (result.success)
                    setState(prev => ({
                        ...prev,
                        tableData: result.data
                    }))
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
        const {dateRange, email, text} = canSubmits

        return dateRange && email && text;
    }

    // const getCompaniesNameAndSymbolForSelect = () => {
    //     getCompaniesNameAndSymbol()
    //         .then(result => {
    //             if (result.success)
    //                 setState(prev => ({
    //                     ...prev,
    //                     companiesNameAndSymbols: result.data
    //                 }))
    //         })
    // }

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
            <div className={bs.container}>

                <div style={{width: 300}}>
                    <Autocomplete
                        // onChange={getCompaniesLikeForSelect}
                        value={companySymbol}
                        onInput={onChangeSearch('companySymbol')}
                        options={companiesNameAndSymbols.map((el: any) => el.symbol)}
                        // groupBy={(option) => option.name}
                        // getOptionLabel={(option) => option.name}
                        renderInput={(value) => (
                            <TextField {...value} label="Data"/>
                        )}
                    />
                </div>

                <TextInput value={companySymbol} onChange={onChangeSearch('companySymbol')}
                           setSubmit={setSubmitFunc('text')}/>
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
                <div style={{width: 1200}}>
                    <LineChart label={'date'} data={tableData} lines={['open', 'close']}/>
                </div>
            </div>


        </div>
    );

}