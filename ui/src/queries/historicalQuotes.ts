import {requestApi} from '../common/api'

const directory = '/api/historical-quotes/';


function historicalQuotesApi(uri: any, params?: any) {
    let fullUri = directory + uri;
    var fullParams =
        {
            method: 'GET',
            headers: {'Content-Type': 'application/json'},
            ...params
        }
    return requestApi(fullUri, fullParams)
}


export function getHistoricalQuotes(search: any) {
    return historicalQuotesApi(`/api/historical-quotes/get/${search}`);
}

