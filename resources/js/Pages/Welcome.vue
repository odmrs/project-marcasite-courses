<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Welcome" />

    <div class="relative min-h-screen bg-center bg-gray-100">
        <!-- Image -->
        <div class="flex justify-center items-center">
            <img src="/storage/images/center-image.png" alt="Marcasite Logo criada por Marcos" style="max-width: 35%; height: auto;">
        </div>
        <template v-if="$page.props.auth.user">
        <!-- Botões de login/registrar -->
            <div class="top-0 right-0 p-6 text-center">
                <Link
            v-if="$page.props.auth.user && $page.props.auth.user.is_admin"
            :href="route('dashboard')"
            class="font-semibold text-white bg-blue-500 hover:bg-blue-600 dark:bg-blue-700 dark:hover:bg-blue-800 px-4 py-2 rounded-md mb-4 sm:mb-0 sm:me-4 w-500 sm:w-auto focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-100"
        >
            Painel de Administrador
                </Link>
                <Link
            v-else
            :href="route('courses.index')"
            class="font-semibold text-white bg-blue-500 hover:bg-blue-600 dark:bg-blue-700 dark:hover:bg-blue-800 px-4 py-2 rounded-md mb-4 sm:mb-0 sm:me-4 w-500 sm:w-auto focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-100"
        >
            Painel do úsuario
                </Link>
            </div>
        </template>
    <template v-else>
        <div class="top-0 right-0 p-6 text-center">
            <Link
                :href="route('login')"
                class="font-semibold text-white bg-green-400 hover:bg-green-500 dark:bg-green-600 dark:hover:bg-green-700 px-4 py-2 rounded-md mb-4 sm:mb-0 sm:me-4 w-500 sm:w-auto focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-2 focus:ring-offset-gray-100"
            >
                Log in
            </Link>
        </div>
    </template>
        </div>

        <!-- Créditos -->
        <div class="bottom-0 left-0 right-0 p-6 text-center">
            <div class="text-sm text-gray-500 dark:text-gray-400 font-semibold">
                <a href="https://github.com/odmrs" target="_blank">Criado por: Marcos Vinícius (odmrs)</a>
            </div>
        </div>
</template>
