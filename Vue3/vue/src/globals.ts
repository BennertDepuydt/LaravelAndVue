const dev:boolean = false;
let apiString:string = '';

if (dev) {
    apiString = 'http://localhost:8080/api'
} else {
    apiString = 'http://groei.mazzier.be/api'
}

// @ts-ignore
const API: string = apiString

export default API;