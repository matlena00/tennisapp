<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <nav class="bg-gray-800 h-16 p-4 flex justify-between border-b border-b-white">
        <div class="flex gap-4">
            <Link :href="route('dashboard')"
            class="flex flex-row gap-3 items-center">
                <ApplicationLogo
                    class="block h-9 w-auto fill-current text-white"
                />
                <p class="text-white">tenisso</p>
            </Link>

        </div>
        <div class="flex flex-row gap-3">
            <Link :href="route('login')"
                  class="flex items-center bg-white text-gray-800 leading-4 rounded-md p-4">
                Zaloguj się
            </Link>
            <Link :href="route('register')"
                  class="flex items-center text-white leading-4 border rounded-md py-3 p-4">
                Załóż konto
            </Link>
        </div>
    </nav>
    <div class="h-[calc(100vh-64px)] flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-800">
        <div
            class="w-full sm:max-w-lg px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
