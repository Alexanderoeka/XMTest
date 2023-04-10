import React from "react";
import {pr} from "../../common/utils";
import TableRowBoxN from "./TableRowBoxN";
import {ColumnI} from "./TableNew";
import g from '../parts/general.module.css'

interface PropsI {
    values: any,
    columnTypes: ColumnI[],
    id: number
}

export default function TableRowN(props: PropsI) {
    const {values, id} = props
    return (
        <tr className={g.tableRow}>
            {props.columnTypes?.map((col: ColumnI, idx) => {
                return <TableRowBoxN value={props.values[col.id]} columnTypes={col}/>
            })}
        </tr>
    )
}