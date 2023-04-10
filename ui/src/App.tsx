import React from 'react';
import logo from './logo.svg';
import './App.css';
import Routing from "./common/Routing";
import {DateTimePicker, LocalizationProvider} from '@mui/x-date-pickers';
import {AdapterDayjs} from '@mui/x-date-pickers/AdapterDayjs';
import Links from "./components/Links";
import {Button as MButton} from "@mui/material";

function App() {
    return (
        <div className="App">
            <LocalizationProvider dateAdapter={AdapterDayjs}>
                <Routing/>
            </LocalizationProvider>

        </div>
    );
}

export default App;
