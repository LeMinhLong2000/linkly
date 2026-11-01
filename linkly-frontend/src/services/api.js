import axios from 'axios';

const api = axios.create({
    baseURL: import.meta.env.VITE_API_BASE_URL,

    headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
    },

    timeout: 10000,
});

// Tự động đính kèm token vào mỗi request
api.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem('auth_token');

        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }

        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

export default api;