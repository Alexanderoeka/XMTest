import React from "react";
import g from './general.module.css'

interface propsI {
    value?: string | number | undefined,
    onSubmit: () => void
}

export default function Button(props: propsI) {

    return (
        <div>
            <input className={g.button} type="button" onClick={props.onSubmit} value={props.value}/>
        </div>
    )
}