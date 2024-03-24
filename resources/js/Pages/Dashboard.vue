<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Aside from '@/Layouts/Aside.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout></AuthenticatedLayout>
    <Aside></Aside>
    <div class="ml-[256px] md:p-6 lg:p-12 bg-gray-100 h-[calc(100vh-64px)]">
        <div class="grid sm:grid-cols-1 md:grid-cols-2 2xl:grid-cols-3">
            <div class="flex bg-green-400">
                test
            </div>
            <div class=" flex bg-violet-400">
                test 2
            </div>
        </div>
    </div>
</template>
