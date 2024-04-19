<script setup>
import { defineProps } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Aside from "@/Layouts/Aside.vue";
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    courts: Array,
});
</script>

<template>
    <AuthenticatedLayout></AuthenticatedLayout>
    <Aside></Aside>
    <main class="ml-[256px] md:p-6 lg:p-12 bg-gray-100 h-[calc(100vh-64px)]">
        <h1 class="mb-8 text-3xl font-bold">Rezerwuj swój ulubiony kort!</h1>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 gap-8 lg:grid-cols-3">
            <div v-for="court in courts" :key="court.id">
                <Link :href="`/reserve/${court.id}`" :class="{'grass': court.surface === 'grass', 'clay': court.surface === 'clay', 'hard': court.surface === 'hard'}"
                     class="flex flex-col w-full px-6 py-4 rounded-md text-white">
                    <h3 class="font-bold text-2xl mb-2">{{court.name}}</h3>
                    <p class="mb-4">{{court.description}}</p>
                    <p class="">Otwarcie: {{court.opening_time}}</p>
                    <p class="">Zamknięcie: {{court.closing_time}}</p>
                </Link>
            </div>
        </div>
    </main>
</template>

<style scoped>
.grass {
    background-color: #4CAF50;
}
.clay {
    background-color: #FF5722;
}
.hard {
    background-color: #2196F3;
}
</style>
