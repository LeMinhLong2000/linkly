<script setup>
import { ref } from 'vue';
import AuthLayout from '@/layouts/AuthLayout.vue';

const name = ref('');
const email = ref('');
const password = ref('');
const passwordConfirmation = ref('');

const errorMessage = ref('');

const handleSubmit = () => {
    errorMessage.value = '';

    if (
        !name.value ||
        !email.value ||
        !password.value ||
        !passwordConfirmation.value
    ) {
        errorMessage.value = 'Please complete all fields.';
        return;
    }

    if (password.value.length < 8) {
        errorMessage.value = 'Password must be at least 8 characters.';
        return;
    }

    if (password.value !== passwordConfirmation.value) {
        errorMessage.value = 'Passwords do not match.';
        return;
    }

    // Registration API will be integrated in Stage 5.
    errorMessage.value = 'Registration API integration is coming next.';
};
</script>

<template>
    <AuthLayout>
        <div class="auth-heading">
            <h1>Create your account</h1>
            <p>Start managing your links with Linkly.</p>
        </div>

        <div v-if="errorMessage" class="auth-message" role="status">
            {{ errorMessage }}
        </div>

        <form @submit.prevent="handleSubmit">
            <div class="form-group">
                <label for="name">Full name</label>

                <input
                    id="name"
                    v-model.trim="name"
                    type="text"
                    class="form-input"
                    placeholder="John Doe"
                    autocomplete="name"
                    required
                />
            </div>

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
                    placeholder="At least 8 characters"
                    autocomplete="new-password"
                    minlength="8"
                    required
                />
            </div>

            <div class="form-group">
                <label for="passwordConfirmation">
                    Confirm password
                </label>

                <input
                    id="passwordConfirmation"
                    v-model="passwordConfirmation"
                    type="password"
                    class="form-input"
                    placeholder="Re-enter your password"
                    autocomplete="new-password"
                    required
                />
            </div>

            <button type="submit" class="btn-primary">
                Create account
            </button>
        </form>

        <div class="auth-footer">
            Already have an account?
            <router-link to="/login">Sign in</router-link>
        </div>
    </AuthLayout>
</template>
