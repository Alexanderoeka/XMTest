import React from "react";
import {ColumnI} from "./TableNew";
import g from '../parts/general.module.css';


interface filter {

}

interface propsI {
    value: ColumnI,
    orderByColumn?: (orderBy: string) => () => void,
    order: 'asc' | 'desc',
    orderBy: string | null
}


export default function TableHeaderBoxN(props: propsI) {
    const {orderByColumn} = props

    const arrowUpDown = () => {

        let arrow = <i></i>;
        if (props.value.id === props.orderBy) {
            if (props.order === 'asc')
                arrow = <i className={g.arrowDown}/>
            else if (props.order === 'desc')
                arrow = <i className={g.arrowUp}/>
        }

        return (arrow)
    }

    const orderByColumnDecorator = (id: string) => () => {

        if (typeof orderByColumn !== "undefined")
            orderByColumn(id)
    }


    return (
        <th className={g.theadth} onClick={orderByColumnDecorator(props.value.id)}>
            {props.value?.text}
            {arrowUpDown()}
        </th>
    )
}