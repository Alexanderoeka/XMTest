import React, {useState} from "react";
import {pr} from "../../common/utils";
import {Autocomplete, Input, TextField} from "@mui/material";

interface PropsI {
    value: string | null,
    onChange: (value: any) => void,
    options: any[]
    setSubmit?: (value: boolean) => void
}


export default function SearchField(props: PropsI) {

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

    const {value, onChange, setSubmit, options} = props;
    const {isValid} = state;
    return (
        <div>
            {!isValid && <div style={{color: 'red', fontSize: '14px'}}>*Text is not vald</div>}
            <div style={{width: 300}}>
                <Autocomplete
                    onSelect={change}
                    freeSolo={true}
                    value={value}
                    onInput={change}
                    options={options.map((el: any) => el.symbol)}
                    renderInput={(value) => (
                        <TextField {...value} label="Data"/>
                    )}
                />
            </div>
        </div>
    );
}