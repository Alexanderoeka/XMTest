import React from "react";
import g from 'general.module.css';

interface propsI {
    value?: string | number | undefined,
    onChange: (e: any)=>void
}

export default function Input(props: propsI) {

    const {onChange} = props
    return (
        <div>
            <input type="text" value={props.value} onChange={onChange}/>
        </div>
    )
}