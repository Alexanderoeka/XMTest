import React, {useState} from 'react';
import {BrowserRouter as Router, Routes, Route} from "react-router-dom";
import Links from "../components/Links";
import HistoricalQuotesFormPage from "../pages/HistoricalQuotesFormPage";
import Popup from "../components/Popup";

export default function Routing() {

    const [state, setState] = useState({
        popup: { show: false, value: '' }
    })



    /** TODO make POPUP!!! */
    const showPopup = (text: any) => {
        setState(prev => ({
            ...prev,
            popup: {
                ...prev.popup,
                value: text,
                show: true
            }
        }))
    }



    const hidePopup = () => {
        setState(prev => ({
            ...prev,
            popup: {
                ...prev.popup,
                value: '',
                show: false
            }
        }))
    }
    return (
        <Router>
            <Routes>
                <Route path="/" element={<HistoricalQuotesFormPage popup={showPopup}/>}/>
                <Route path="/historical-quotes-form" element={<HistoricalQuotesFormPage popup={showPopup}/>}/>
            </Routes>
            {state.popup.show && <Popup click={hidePopup} value={state.popup.value} />}
        </Router>
    );
}