
<template>
    <main class="auth-page">
        <div class="auth-container">
            <router-link to="/" class="brand">
                <div class="brand-icon">L</div>
                <span class="brand-name">Linkly</span>
            </router-link>

            <div class="auth-card">
                <slot />
            </div>

            <p class="auth-footer">
                &copy; {{ new Date().getFullYear() }} Linkly.
                All rights reserved.
            </p>
        </div>
    </main>
</template>
