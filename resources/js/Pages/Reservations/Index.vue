<script setup>
import { defineProps } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Aside from "@/Layouts/Aside.vue";
import MainContent from "@/Components/MainContent.vue";
import {Head, Link} from "@inertiajs/vue3";

const props = defineProps({
    courts: Array,
});
</script>

<template>
    <Head title="Rezerwacja kortu" />
    <AuthenticatedLayout></AuthenticatedLayout>
    <Aside></Aside>
    <MainContent>
        <h1 class="mb-8 text-3xl font-bold">Rezerwuj swój ulubiony kort!</h1>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 gap-8 lg:grid-cols-3">
            <div v-for="court in courts" :key="court.id">
                <Link :href="`/reserve/${court.id}`" :class="{'grass': court.surface === 'grass', 'clay': court.surface === 'clay', 'hard': court.surface === 'hard'}"
                     class="flex flex-col w-full px-6 py-4 rounded-md text-white opacity-85 hover:opacity-100">
                    <h3 class="font-bold text-2xl mb-2">{{court.name}}</h3>
                    <p class="mb-4">{{court.description}}</p>
                    <p class="">Otwarcie: {{court.opening_time}}</p>
                    <p class="">Zamknięcie: {{court.closing_time}}</p>
                    <span class="p-4 mt-3 text-white bg-gray-800 w-fit rounded-md">Cena za 1h: {{court.hourly_rate}} zł</span>
                </Link>
            </div>
        </div>
    </MainContent>
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
