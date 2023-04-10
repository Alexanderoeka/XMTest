import React from "react";
import {Line} from "react-chartjs-2";
import {Chart as ChartJS, registerables} from 'chart.js';
import {Chart} from 'react-chartjs-2'
import {pr} from "../common/utils";

ChartJS.register(...registerables);

export default function LineChart(props: any) {
    const {data, label, lines} = props;

    let linesLine: any = lines.map((line: any) => ({
        label: line,
        data: data.map((el: any) => el[line])
    }));

    pr(linesLine);

    let dataChart = {
        labels: props.data.map((el: any) => el[label]),
        datasets: [
            ...linesLine
        ]
    }
    return (<div>
        qdqwed
        <Line data={dataChart}/>
    </div>)

}