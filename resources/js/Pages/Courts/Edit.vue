<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Aside from "@/Layouts/Aside.vue";
</script>

<template>
    <AuthenticatedLayout></AuthenticatedLayout>
    <Aside></Aside>
    <div class="ml-[256px] p-8 bg-gray-100 h-[calc(100vh-64px)]">
        <h1 class="mb-8 text-3xl font-bold">Edycja kortu</h1>
    </div>
</template>

<style scoped>

</style>
