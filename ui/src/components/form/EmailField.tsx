import React, {useState} from "react";
import {TextField} from "@mui/material";
import {pr} from "../../common/utils";


interface PropsI {
    value: string | null,
    onChange: (value: any) => void,
    setSubmit?: (value: boolean) => void
}

export default function EmailField(props: PropsI) {

    const [state, setState] = useState({
        isValid: false,
        exceptionText: 'Email is not correct'
    });

    const isValidEmail = (email: string) => {
        return /^.+@[a-z]+\.[a-z]+$/.test(email);
    }

    const checkValid = (value: string) => {
        let isValid: boolean = isValidEmail(value);

        setState(prev => ({
            ...prev,
            isValid: isValid
        }))
        if (typeof setSubmit !== "undefined")
            setSubmit(isValid);

    }


    const change = (e: any) => {
        let value = e?.target?.value ?? e;
        checkValid(value)
        pr(value)

        onChange(e);
    }

    const {value, onChange, setSubmit} = props
    const {isValid, exceptionText} = state
    return (
        <>
            {!isValid && <div style={{color: 'red', fontSize: '14px'}}>*{exceptionText}</div>}
            <TextField error={!isValid} type="email" value={value} onChange={change} required={true}
                       helperText={'Enter email'}/>
        </>
    )
}