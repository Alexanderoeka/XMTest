import {requestApi} from '../common/api'

const directory = '/api/historical-quotes/';


function historicalQuotesApi(uri: any, params?: any) {
    let fullUri = uri;
    var fullParams =
        {
            method: 'GET',
            headers: {'Content-Type': 'application/json'},
            ...params
        }
    return requestApi(fullUri, fullParams)
}


export function getHistoricalQuotes(search: any) {
    let urlParams = new URLSearchParams(search).toString();
    return historicalQuotesApi(`/api/historical-quotes/get/?${urlParams}`);
}


export function getCompaniesNameAndSymbol() {
    return historicalQuotesApi('/api/companies-name-symbol/get');
}



export function getCompaniesLike(symbol:any) {
    return historicalQuotesApi(`/api/companies-name-symbol/get/${symbol}`);
}