<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <nav class="bg-primary h-16 p-4 flex justify-between">
        <div class="flex gap-4">
            <Link :href="route('welcome')"
            class="flex flex-row gap-3 items-center">
                <ApplicationLogo
                    class="text-white"
                />
                <p class="text-white font-bold text-3xl ml-[-160px]">tenisso</p>
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
    <div class="h-[calc(100vh-64px)] flex flex-col justify-center px-8 items-center pt-6 sm:pt-0 bg-secondary">
        <div
            class="w-full sm:max-w-lg px-6 py-4 bg-white shadow-md overflow-hidden rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
