import React from "react";
import g from './general.module.css';
import {pr} from "../../common/utils";

type PagingVariations = 10 | 30 | 50

interface PropsI {
    page: number,
    pages: number,
    perPage: PagingVariations,
    onChange: (field: 'perPage' | 'page', value: string | number) => void
}


export default function TablePaginate(props: PropsI) {

    const {page, pages, perPage, onChange} = props

    const changePerPage = (field: 'perPage') => (e: any) => {


        let numberValue: any = +(e.target?.value ?? e);

        let value: PagingVariations = numberValue;

        onChange(field, value)
    }
    const nextPrevPage = (toPage: 'prev' | 'next') => () => {
        let newPage: number;

        switch (toPage) {
            case "prev":
                newPage = page > 1 ? page - 1 : page;
                break;
            case "next":
                newPage = page < pages ? page + 1 : page;
                break;
        }

        onChange('page', newPage)

    }
    return (
        <div className={g.tablePaginate}>

            <div className={g.paginatePages}>Page: {page} </div>
            <div className={g.paginatePages}>Pages: {pages} </div>
            <select className={g.paginateSelect} onChange={changePerPage('perPage')}>
                <option value={10} label='10'/>
                <option value={30} label='30'/>
                <option value={50} label='50'/>
            </select>
            <div className={g.paginateButton} onClick={nextPrevPage('prev')}>
                <i className={g.arrowLeft}/>
            </div>
            <div className={g.paginateButton} onClick={nextPrevPage('next')}>
                <i className={g.arrowRight}/>
            </div>
        </div>
    )
}