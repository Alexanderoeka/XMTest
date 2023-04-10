import React, {useState} from "react";

import {Button, Input, TextField} from "@mui/material";
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


export default function HistoricalQuotesFormPage() {

    const [state, setState] = useState({
        companySymbol: null,
        startDate: null,
        endDate: null,
        email: null,
        canSubmits: {
            text: false,
            dateRange: false,
            email: false
        }

    });


    const onChange = (name: string) => (e: any) => {
        let value = e?.target?.value ?? e;
        pr(e)
        pr(value)

        setState(prev => ({
            ...prev,
            [name]: value
        }))
    }

    const submit = () => {
        pr('dq')
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


    const {companySymbol, startDate, endDate, email} = state

    return (
        <div>
            <div className={bs.container}>
                <TextInput value={companySymbol} onChange={onChange('companySymbol')}
                           setSubmit={setSubmitFunc('text')}/>
                <DatePickerRange startDate={startDate} endDate={endDate} onChange={onChange}
                                 setSubmit={setSubmitFunc('dateRange')}/>
                <EmailField value={email} onChange={onChange('email')} setSubmit={setSubmitFunc('email')}/>
                <Button color={"secondary"} variant={"contained"} onClick={submit} disabled={!canSubmit()}>Get Data
                    table</Button>
            </div>
        </div>
    );

}