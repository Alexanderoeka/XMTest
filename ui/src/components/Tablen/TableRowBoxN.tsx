import React from "react";
import {ColumnI} from "./TableNew";
import g from '../parts/general.module.css';

export type Column = string | number | boolean | null | any

interface PropsI {
    value?: Column,
    columnTypes: ColumnI,
}

export default function TableRowBoxN(props: PropsI) {

    const {value, columnTypes} = props

    // let finalValue = typeof value === "boolean" ? value.toString() : value;
    let td = <td>{value}</td>


    if (props.columnTypes?.type === "change" && typeof value === "boolean") {
        td = <td><input className={g.checkbox} type="checkbox" checked={value}/></td>
    } else if (props.columnTypes.type === "date" && value) {
        td = <td>{value?.date}</td>
    }

    return (
        <>
            {td}
        </>
    )
}