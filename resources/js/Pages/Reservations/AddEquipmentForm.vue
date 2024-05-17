<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Aside from "@/Layouts/Aside.vue";
import MainContent from '@/Components/MainContent.vue';
import { defineProps } from 'vue';
import { useForm } from '@inertiajs/vue3';
import axios from 'axios';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    reservation: Object,
    equipment: {
        type: Array,
        default: () => []
    }
});

const form = useForm({
    equipment: props.equipment.map(equip => ({
        id: equip.id,
        quantity: 0
    }))
});

const addEquipmentToReservation = async () => {
    try {
        const response = await axios.post(`/reservations/${props.reservation.id}/add-equipment`, {
            equipment: form.equipment.filter(equip => equip.quantity > 0)
        });
        Inertia.visit('/dashboard');
    } catch (error) {
        console.error('Error during adding equipment to reservation:', error);
    }
};
</script>

<template>
    <AuthenticatedLayout></AuthenticatedLayout>
        <Aside></Aside>
        <MainContent>
            <h1 class="mb-8 text-3xl font-bold">Dodaj sprzęt do rezerwacji</h1>
            <div>
                <p>Kort: {{ reservation.court.name }}</p>
                <p>Data: {{ reservation.start_time }} - {{ reservation.end_time }}</p>
            </div>
            <div class="mt-8">
                <h2 class="text-xl font-bold mb-4">Wybierz sprzęt:</h2>
                <div v-for="equip in equipment" :key="equip.id" class="">
                    <div class="flex items-center justify-between">
                        <span>{{ equip.name }} (Cena za godzinę: {{ equip.hourly_rate }} zł)</span>
                        <input v-model="form.equipment.find(e => e.id === equip.id).quantity" type="number" min="0" max="4" class="w-20 p-2 border rounded-md text-gray-800" />
                    </div>
                </div>
                <button @click="addEquipmentToReservation" class="bg-blue-500 text-white py-2 px-4 rounded-md">Dodaj sprzęt</button>
            </div>
        </MainContent>
</template>
