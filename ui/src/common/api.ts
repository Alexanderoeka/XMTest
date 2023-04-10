const address = 'http://localhost';
// const address = 'http://34.77.97.231';
// const address = 'http://localhost';

export interface PaginationI {
    page: number,
    pages: number,
    perPage: 10 | 30 | 50,
    order: 'asc' | 'desc',
    orderBy: string,
}


export interface requestResult {
    success: boolean,
    data: any,
    pagination: PaginationI,
    message: string
}


export async function requestApi(uri: string, params: object = {}): Promise<requestResult> {
    let fullUri = address + uri;

    let responce = await fetch(fullUri, params)
    let result = await responce.json()
    return result;
}