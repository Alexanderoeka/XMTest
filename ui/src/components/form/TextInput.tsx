import React, {useState} from "react";
import {pr} from "../../common/utils";
import {Input} from "@mui/material";

interface PropsI {
    value: string | null,
    onChange: (value: any) => void,
    setSubmit?: (value: boolean) => void
}


export default function TextInput(props: PropsI) {

    const [state, setState] = useState({
        isValid: false
    })

    const checkValid = (value: string) => {
        let isValid: boolean = !!value;
        setState({isValid: !!value})

        if (typeof setSubmit !== "undefined")
            setSubmit(isValid);

    }

    const change = (e: any) => {

        let value = e?.target?.value ?? e;
        pr(value)

        checkValid(value);


        onChange(value);
    }

    const {value, onChange, setSubmit} = props;
    const {isValid} = state;
    return (
        <div>
            {!isValid && <div style={{color: 'red', fontSize: '14px'}}>*Text is not vald</div>}
            <Input value={value} onChange={change} type={"text"}/>
        </div>
    );
}