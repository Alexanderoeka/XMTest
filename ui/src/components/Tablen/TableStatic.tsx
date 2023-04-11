import React, {useEffect, useState} from "react";
import TableHeaderN from "./TableHeaderN";
import {SearchI} from "../../pages/TablePage";
import TableRowN from "./TableRowN";
import g from '../parts/general.module.css';
import ts from "../styles/tableStyle.module.css";
import TablePaginate from "../parts/TablePaginate";
import {pr} from "../../common/utils";
import {requestResult} from "../../common/api";

export interface ColumnI {
    id: string,
    text: string,
}
export interface SearchTableI extends Omit<SearchI, 'search'> {
    refreshLocal: boolean,
    rows: number
}

export interface SearchTParamsI {
    perPage: 10 | 30 | 50,
    page: number,
    order: 'asc' | 'desc',
    orderBy: string | null,
}

export interface propsI {
    getTableData?: (params: SearchTParamsI) => Promise<requestResult>,
    tableData: any[],
    columnsTypes: ColumnI[],
    searchButton?: boolean,
    search?: string | null
}


export default function TableStatic(props: propsI) {
    const {getTableData, columnsTypes, searchButton, tableData} = props

    const [state, setState] = useState<SearchTableI>({
        page: 1,
        pages: 1,
        perPage: 10,
        order: 'asc',
        orderBy: columnsTypes[0].id,
        rows: 0,
        // tableData: [],
        refreshLocal: false
    })

    const { orderBy, order} = state

    return (
        <div className={ts.box}>

            <div className={g.tableScroll}>
                <table className={g.tableBeauty}>
                    <thead>
                    <TableHeaderN columnsTypes={columnsTypes} order={order}
                                  orderBy={orderBy}/>
                    </thead>
                    <tbody>
                    {tableData.map((row: any, idx) => {
                        return <TableRowN id={idx} values={row}
                                          columnTypes={columnsTypes}/>
                    })}
                    </tbody>
                </table>
            </div>
        </div>
    )
}