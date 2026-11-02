import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '@/stores/auth';

// Import Views
const HomeView = () => import('@/views/HomeView.vue');
const LoginView = () => import('@/views/LoginView.vue');
const RegisterView = () => import('@/views/RegisterView.vue');
const DashboardView = () => import('@/views/DashboardView.vue');

const routes = [
    {
        path: '/',
        name: 'home',
        component: HomeView,
    },
    {
        path: '/login',
        name: 'login',
        component: LoginView,
        meta: {
            guestOnly: true,
        },
    },
    {
        path: '/register',
        name: 'register',
        component: RegisterView,
        meta: {
            guestOnly: true,
        },
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: DashboardView,
        meta: {
            requiresAuth: true,
        },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

// Navigation Guard
router.beforeEach(async (to) => {
    const authStore = useAuthStore();

    // Kiểm tra trang yêu cầu đăng nhập
    if (to.meta.requiresAuth) {

        // Chưa có token
        if (!authStore.token) {
            return {
                name: 'login',
                query: {
                    redirect: to.fullPath,
                },
            };
        }

        // Có token nhưng chưa có thông tin user
        // Thường xảy ra khi reload trình duyệt
        if (!authStore.user) {
            try {
                await authStore.fetchUser();
            } catch (error) {
                if (error.response?.status === 401) {
                    authStore.clearAuth();
                }

                return {
                    name: 'login',
                    query: {
                        redirect: to.fullPath,
                    },
                };
            }
        }

        // Kiểm tra trạng thái xác thực
        if (!authStore.isAuthenticated) {
            return {
                name: 'login',
                query: {
                    redirect: to.fullPath,
                },
            };
        }
    }

    // Người đã đăng nhập không cần truy cập Login/Register
    if (to.meta.guestOnly && authStore.isAuthenticated) {
        return {
            name: 'dashboard',
        };
    }
});

export default router;
