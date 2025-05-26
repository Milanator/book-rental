import axios from "axios";

const axiosConfig = {
    baseURL: import.meta.env.VITE_API_URL,
    headers: {
        common: {
            "X-Requested-With": "XMLHttpRequest",
        },
    },
};

const instance = axios.create(axiosConfig);

export default instance;
