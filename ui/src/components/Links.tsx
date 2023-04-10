import React from 'react';
import {Link} from "react-router-dom";
import ls from './styles/linksStyle.module.css';

export default function Links() {
    return (
        <div className={ls.linkGroup}>
            <Link className={ls.linkButton} to="/historical-quotes-form">Historical quotes form</Link>
            <Link className={ls.linkButton} to="/table">Table</Link>
        </div>
    )
}