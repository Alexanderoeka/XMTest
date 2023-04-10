import React, {useState} from "react";
import {DatePicker} from "@mui/x-date-pickers/DatePicker/DatePicker";
import {pr} from "../../common/utils";
import {DatePickerProps, DateTimePicker} from "@mui/x-date-pickers";

interface PropsI {
    startDate: any,
    endDate: any,
    onChange: (name: string) => (value: any) => void,
    setSubmit?: (value: boolean) => void
}


export default function DatePickerRange(props: PropsI) {

    const [state, setState] = useState({
        isValid: false
    })

    const checkValid = (name: 'startDate' | 'endDate', dateClear: { $d: Date }) => {

        let date: Date = dateClear.$d;


        let newDateTime = date.getTime();
        let startDateTime = startDate?.$d.getTime();
        let endDateTime = endDate?.$d.getTime();
        let nowDateTime = (new Date()).getTime();

        let isValid: boolean = false;
        switch (name) {
            case "startDate":
                if (newDateTime <= nowDateTime)
                    if (endDateTime && newDateTime <= endDateTime && endDateTime <= nowDateTime)
                        isValid = true
                break;
            case "endDate":
                if (newDateTime <= nowDateTime)
                    if (startDateTime && newDateTime >= startDateTime && startDateTime <= nowDateTime)
                        isValid = true
                break;
        }

        pr(isValid)

        setState({isValid: isValid})

        if (typeof setSubmit !== "undefined")
            setSubmit(isValid);

    }

    const change = (name: 'startDate' | 'endDate') => (e: any) => {

        let dateClear = e?.target?.value ?? e;

        checkValid(name, dateClear);


        onChange(name)(dateClear);
    }

    const {startDate, endDate, onChange, setSubmit} = props;
    const {isValid} = state;
    return (
        <div>
            {!isValid && <div style={{color: 'red', fontSize: '14px'}}>*Date range is not valid</div>}
            <DatePicker value={startDate} onChange={change('startDate')} format={"DD-MM-YYYY"}
                        views={['year', 'month', 'day']}/>
            1
            <DatePicker value={endDate} onChange={change('endDate')} format={"DD-MM-YYYY"}
                        views={['year', 'month', 'day']}/>
            2
        </div>
    );
}