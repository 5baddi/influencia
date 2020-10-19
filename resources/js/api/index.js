import axios from 'axios'
const api = axios.create({
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
    },
    baseURL: process.env.API_URL
});
// api.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// api.defaults.withCredentials = true;

export { api };