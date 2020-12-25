import axios from 'axios';
import { router } from '../routes';

const api = axios.create({
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
    },
    baseURL: process.env.API_URL
});

api.interceptors.response.use(null, error => {
    // Init
    let path = "/error";

    // Handle each response status
    switch(error.response.status){
        case 401:
            path = "/login";
        break;
        case 404:
            path = "/404";
        break;
        case 500:
            path = "/error";
        break;
    }

    router.push(path);
    return Promise.reject(error);
});

export { api };