import axios from 'axios';

const api = axios.create({
    baseURL: "https://24fe-187-85-18-181.ngrok.io/api"
})

export default api;