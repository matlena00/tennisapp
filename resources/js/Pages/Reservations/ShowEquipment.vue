<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Aside from "@/Layouts/Aside.vue";
import MainContent from '@/Components/MainContent.vue';
import { defineProps } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    equipment: Array
});

</script>

<template>
    <AuthenticatedLayout></AuthenticatedLayout>
    <Aside></Aside>

    <MainContent>
        <h1 class="mb-2 text-3xl font-bold">Nasz ośrodek dysponuje poniższymi sprzętami</h1>
        <span class="block mb-8 text-md">Jeśli chcesz wypożyczyć któryś z nich, kliknij w przycisk <strong>"Wypożycz sprzęt"</strong>.</span>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 max-w-6xl">
            <div v-for="equip in equipment" :key="equip.id" class="flex flex-col gap-y-2 p-3 bg-accent1 rounded-md">
                <h3 class="text-xl font-bold mb-2">{{ equip.name }}</h3>
                <p class="text-white mb-2">{{ equip.description }}</p>
                <p class="py-3 px-4 bg-secondary rounded-lg text-accent3">Cena za godzinę rezerwacji: {{ equip.hourly_rate }} zł</p>
            </div>
        </div>
        <Link :href="route('select.reservation')" class="block w-fit mt-4 bg-accent3 text-secondary font-bold py-2 px-4 rounded-md">Wypożycz sprzęt</Link>
    </MainContent>
</template>
