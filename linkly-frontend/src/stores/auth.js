
import { defineStore } from 'pinia';
import api from '@/services/api';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null,
        token: localStorage.getItem('auth_token') || null,
        isLoading: false,
    }),

    getters: {
        isAuthenticated: (state) => {
            return Boolean(state.token && state.user);
        },

        currentUser: (state) => state.user,
    },

    actions: {
        // Lưu thông tin đăng nhập
        setAuth(user, token) {
            this.user = user;
            this.token = token;

            localStorage.setItem('auth_token', token);
        },

        // Xóa thông tin đăng nhập
        clearAuth() {
            this.user = null;
            this.token = null;

            localStorage.removeItem('auth_token');
        },

        // Đăng ký tài khoản
        async register(formData) {
            this.isLoading = true;

            try {
                const response = await api.post('/auth/register', formData);

                const { user, token } = response.data.data;

                this.setAuth(user, token);

                return user;
            } finally {
                this.isLoading = false;
            }
        },

        // Đăng nhập
        async login(credentials) {
            this.isLoading = true;

            try {
                const response = await api.post('/auth/login', credentials);

                const { user, token } = response.data.data;

                this.setAuth(user, token);

                return user;
            } finally {
                this.isLoading = false;
            }
        },

        // Lấy thông tin người dùng hiện tại
        async fetchUser() {
            if (!this.token) {
                return null;
            }

            try {
                const response = await api.get('/auth/me');

                this.user = response.data.data;

                return this.user;
            } catch (error) {
                if (error.response?.status === 401) {
                    this.clearAuth();
                }

                throw error;
            }
        },

        // Đăng xuất
        async logout() {
            try {
                if (this.token) {
                    await api.post('/auth/logout');
                }
            } finally {
                this.clearAuth();
            }
        },
    },
});
