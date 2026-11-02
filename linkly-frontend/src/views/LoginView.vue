<script setup>
import { ref } from 'vue';
import AuthLayout from '@/layouts/AuthLayout.vue';

const email = ref(''); //Tạo reactive state
const password = ref('');
const rememberMe = ref(false);
const errorMessage = ref('');

const handleSubmit = () => {
    errorMessage.value = '';

    if (!email.value || !password.value) {
        errorMessage.value = 'Please enter your email and password.';
        return;
    }

    // Authentication API will be integrated in Stage 5.
    errorMessage.value = 'Login API integration is coming next.';
};
</script>

<template>
    <AuthLayout>
        <div class="auth-heading">
            <h1>Welcome back</h1>
            <p>Enter your credentials to access your account.</p>
        </div>

        <div v-if="errorMessage" class="auth-message" role="status">
            {{ errorMessage }}
        </div>

        <!-- Xử lý submit, ngăn reload trang -->
        <form @submit.prevent="handleSubmit"> 
            <div class="form-group">
                <label for="email">Email address</label>

                <input
                    id="email"
                    v-model.trim="email"
                    type="email"
                    class="form-input"
                    placeholder="you@example.com"
                    autocomplete="email"
                    required
                />
            </div>

            <div class="form-group">
                <label for="password">Password</label>

                <input
                    id="password"
                    v-model="password"
                    type="password"
                    class="form-input"
                    placeholder="Enter your password"
                    autocomplete="current-password"
                    required
                />
            </div>

            <div class="form-group">
                <label>
                    <input
                        v-model="rememberMe"
                        type="checkbox"
                    />
                    Remember me
                </label>
            </div>

            <button type="submit" class="btn-primary">
                Sign in
            </button>
        </form>

        <div class="auth-footer">
            Don't have an account?
            <router-link to="/register">Sign up</router-link>
        </div>
    </AuthLayout>
</template>
