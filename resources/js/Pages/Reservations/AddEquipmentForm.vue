<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Aside from "@/Layouts/Aside.vue";
import MainContent from '@/Components/MainContent.vue';
import { defineProps, ref, watchEffect } from 'vue';
import { useForm } from '@inertiajs/vue3';
import axios from 'axios';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    reservation: Object,
    equipment: {
        type: Array
    }
});

const equipmentWithSelectedQuantity = ref(
    props.equipment.map(equip => ({
        ...equip,
        selectedQuantity: 0
    }))
);

const filteredEquipment = ref(
    equipmentWithSelectedQuantity.value.filter(equip => equip.available_quantity > 0)
);

const form = useForm({
    equipment: equipmentWithSelectedQuantity.value
});

watchEffect(() => {
    form.equipment = equipmentWithSelectedQuantity.value;
});

const addEquipmentToReservation = async () => {
    try {
        const equipmentData = form.equipment
            .filter(equip => equip.selectedQuantity > 0)
            .map(equip => ({
                id: equip.id,
                quantity: equip.selectedQuantity
            }));

        const response = await axios.post(`/reservations/${props.reservation.id}/add-equipment`, {
            equipment: equipmentData
        });
        Inertia.visit('/dashboard');
    } catch (error) {
        console.error('Error during adding equipment to reservation:', error);
    }
};

const increment = (equipment) => {
    if (equipment.selectedQuantity < 4 && equipment.selectedQuantity < equipment.available_quantity) {
        equipment.selectedQuantity++;
    }
};

const decrement = (equipment) => {
    if (equipment.selectedQuantity > 0) {
        equipment.selectedQuantity--;
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
            <div class="grid grid-cols-3 gap-4 max-w-6xl">
                <div v-for="equip in filteredEquipment" :key="equip.id" class="items-center bg-accent1 rounded-lg gap-2 my-2">
                    <div v-if="equip.available_quantity > 0" class="h-full flex flex-col justify-center content-center items-center p-2 gap-y-2">
                        <div class="flex gap-x-2 content-center items-center">
                            <button @click.stop="decrement(equip)" class="px-3 py-1 bg-secondary text-white h-8 w-8 rounded-full">-</button>
                            <input v-model="equip.selectedQuantity" class="text-center w-16 rounded-md text-gray-800" type="number" min="0" :max="equip.available_quantity">
                            <button @click.stop="increment(equip)" class="px-3 py-1 bg-accent3 text-white h-8 w-8 rounded-full">+</button>
                        </div>
                        <span class="text-accent3 font-bold">{{ equip.name }} (dostępnych: {{equip.available_quantity}})</span>
                        <div class="flex justify-around w-full">
                            <span class="text-white">1 szt: {{ equip.hourly_rate }} zł</span>
                            <span class="text-white">suma: {{ equip.selectedQuantity * equip.hourly_rate }} zł</span>
                        </div>
                    </div>
                </div>
            </div>

            <button @click="addEquipmentToReservation" class="bg-accent3 text-secondary py-2 px-4 mt-2 rounded-md">Dodaj sprzęt</button>
        </div>
    </MainContent>
</template>
