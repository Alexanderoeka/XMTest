import React from 'react';
import {BrowserRouter as Router, Routes, Route} from "react-router-dom";
import TablePage from "../pages/TablePage";
import Links from "../components/Links";
import HistoricalQuotesFormPage from "../pages/HistoricalQuotesFormPage";

export default function Routing() {
    return (
        <Router>
            <Links/>
            <Routes>
                <Route path="/" element={<HistoricalQuotesFormPage/>}/>
                <Route path="/historical-quotes-form" element={<HistoricalQuotesFormPage/>}/>
                <Route path="/table" element={<TablePage/>}/>
            </Routes>
        </Router>
    );
}