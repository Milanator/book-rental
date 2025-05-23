import axios from "axios";

const axiosConfig = {
    baseURL: process.env.MIX_API_URL,
};

export default axios.create(config);
