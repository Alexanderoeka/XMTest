import React from "react";
import types from 'prop-types'
import co from './parts/general.module.css';


interface propI {
    className: string | null,
    value: string | null,
    click: () => void
}

/** Default popap for some notification that imported for all pages
 * TODO might import it as decorator (@ - at)
 */
export default function Popup(props: propI) {

    const {click, value} = props

    return (
        <div>
            <div className={co.popupHover} onClick={click}>
            </div>
            <div className={co.popupBox}>
                {value}
                <div className={co.ok} onClick={click}> OK</div>
            </div>
        </div>

    )
}


Popup.defaultProps = {
    className: '',
    value: '',
    click: () => {
    }
}