<script setup>
import { defineProps, ref, computed } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Aside from "@/Layouts/Aside.vue";
import MainContent from "@/Components/MainContent.vue";
import { Link, usePage } from "@inertiajs/vue3";
import axios from 'axios';
import moment from 'moment';

const props = defineProps({
    court: Object,
    start_time: String,
    end_time: String,
    user_id: Number,
    total_price: Number // Nowy parametr
});

const user = usePage().props.auth.user;
const form = ref({
    ...props.court,
    start_time: props.start_time,
    end_time: props.end_time,
    user_id: user.id,
    user_email: user.email,
    equipment: [],
    total: props.total_price // Inicjalizacja z wartością total_price
});

console.log(form.value.total);

const availableEquipment = ref([]);
const isSubmitting = ref(false);
const modalOpen = ref(false);

const loadAvailableEquipments = async () => {
    modalOpen.value = !modalOpen.value;

    const startDate = moment(form.value.start_time).format('YYYY-MM-DD HH:mm:ss');
    const endDate = moment(form.value.end_time).format('YYYY-MM-DD HH:mm:ss');

    try {
        const response = await axios.get('/api/equipment/available', {
            params: {
                start_time: startDate,
                end_time: endDate
            }
        });
        availableEquipment.value = response.data.map(equip => ({
            ...equip,
            selectedQuantity: 0
        }));
    } catch (error) {
        console.error('Error fetching available equipment:', error);
    }
};

const finalizeReservation = () => {
    const reservationDurationHours = moment(form.value.end_time).diff(moment(form.value.start_time), 'hours', true);

    form.value.equipment = availableEquipment.value.filter(equip => equip.selectedQuantity > 0)
        .map(equip => ({
            id: equip.id,
            quantity: equip.selectedQuantity,
            rate: equip.hourly_rate
        }));

    const equipmentTotal = form.value.equipment.reduce((total, equip) => {
        return total + (equip.quantity * equip.rate * reservationDurationHours);
    }, 0);

    form.value.total = parseFloat(props.total_price) + equipmentTotal;
    modalOpen.value = false;
};

const makeReservation = async () => {
    if (isSubmitting.value) {
        return;
    }
    isSubmitting.value = true;

    const start = moment(form.value.start_time).format('YYYY-MM-DD HH:mm:ss');
    const end = moment(form.value.end_time).format('YYYY-MM-DD HH:mm:ss');

    try {
        await axios.post('/reservations', {
            user_id: form.value.user_id,
            user_email: form.value.user_email,
            court_id: props.court.id,
            start_time: start,
            end_time: end,
            equipment: form.value.equipment,
            total_price: form.value.total
        });
        Inertia.visit('/dashboard');
    } catch (error) {
        console.error('Error during saving reservation:', error);
        isSubmitting.value = false;
    }
};

const increment = (equipment) => {
    if (equipment.selectedQuantity < 4) {
        equipment.selectedQuantity++;
    }
};

const decrement = (equipment) => {
    if (equipment.selectedQuantity > 0) {
        equipment.selectedQuantity--;
    }
};

const totalPrice = computed(() => {
    const reservationDurationHours = moment(form.value.end_time).diff(moment(form.value.start_time), 'hours', true);
    return availableEquipment.value.reduce((total, equip) => {
        return total + (equip.selectedQuantity * equip.hourly_rate * reservationDurationHours);
    }, 0);
});

const removeItem = (equipment) => {
    const reservationDurationHours = moment(form.value.end_time).diff(moment(form.value.start_time), 'hours', true);
    form.value.total -= equipment.hourly_rate * equipment.selectedQuantity * reservationDurationHours;
    console.log(equipment.hourly_rate * equipment.selectedQuantity * reservationDurationHours);
    equipment.selectedQuantity = 0;
};
</script>

<template>
    <AuthenticatedLayout></AuthenticatedLayout>
    <Aside></Aside>
    <MainContent>
        <h1 class="mb-2 text-3xl font-bold">Sprawdź poprawność danych i potwierdź rezerwację</h1>
        <span class="block mb-8 text-md">Jeśli chcesz wypożyczyć sprzęt do tej rezerwacji kliknij w przycisk <strong>"Dodaj sprzęt"</strong>.</span>
        <form @submit.prevent="makeReservation" class="max-w-6xl p-2 bg-primary rounded-md">
            <div class="flex flex-col gap-2 p-6">
                <input v-model="form.name" class="pr-6 w-full rounded-md border-b border-gray-800 text-gray-800" label="Name" readonly />
                <div class="flex justify-between gap-x-8">
                    <input v-model="form.start_time" class="text-gray-800 w-full rounded-md" type="datetime-local" label="Opening Time" readonly>
                    <input v-model="form.end_time" class="text-gray-800 w-full rounded-md" type="datetime-local" label="Closing Time" readonly>
                </div>
                <div>
                    <span class="block px-3 py-2 rounded-lg bg-secondary w-fit">Łączna suma: {{ form.total }} zł</span>
                </div>
                <div class="flex justify-between">
                    <div class="flex gap-4">
                        <Link href="/reservations/index" class="mt-4 bg-accent3 text-secondary font-bold w-fit py-2 px-4 rounded-lg hover:underline">Anuluj</Link>
                        <button class="mt-4 bg-secondary text-accent3 w-fit py-2 px-4 rounded-lg font-bold hover:underline">Rezerwuj</button>
                    </div>
                    <div @click="loadAvailableEquipments" v-if="availableEquipment.length < 1" class="mt-4 bg-accent1 text-white font-bold w-fit py-2 px-4 rounded-lg hover:underline">Dodaj sprzęt</div>
                </div>
                <div v-if="availableEquipment.length > 0">
                    <span v-show="availableEquipment.length <= 0" class="block my-3 font-bold text-xl">Dodatkowy sprzęt:</span>
                    <div class="mt-4 grid grid-cols-1 gap-4">
                        <div v-for="equipment in availableEquipment" :class="{ 'hidden': equipment.selectedQuantity <= 0 }" :key="equipment.id">
                            <div v-show="equipment.selectedQuantity > 0" class="p-3 bg-secondary rounded-md">
                                <div class="flex gap-x-4 justify-between content-center items-center">
                                    <div>
                                        <div>
                                            <h3 class="text-white font-bold">{{ equipment.name }} ({{equipment.selectedQuantity}} szt.)</h3>
                                            <p class="text-gray-300">{{ equipment.description }}</p>
                                        </div>
                                    </div>
                                    <div class="flex gap-x-6 justify-center items-center content-center">
                                        <div>
                                            <p class="text-gray-300">{{ equipment.hourly_rate * equipment.selectedQuantity }} zł</p>
                                        </div>
                                        <button @click.prevent="removeItem(equipment)" class="text-3xl">&times;</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </MainContent>
    <div v-if="modalOpen" class="fixed inset-0 w-full h-full bg-black bg-opacity-75 flex justify-center items-center">
        <div class="relative bg-secondary p-6 rounded-md w-3/4">
            <button @click="modalOpen = false" class="absolute top-2 right-2 text-white text-3xl leading-none hover:text-gray-300">&times;</button>
            <h3 class="text-center text-accent3 text-2xl mb-2 font-bold">Dodaj sprzęt do rezerwacji</h3>
            <span class="block text-center text-white font-bold mb-4">Aktualnie możesz wypożyczyć następujące sprzęty (maksymalna liczba sztuk dla 1 rezerwacji wynosi 4)</span>
            <div class="grid grid-cols-3 gap-4">
                <div v-for="equip in availableEquipment" :key="equip.id" class="items-center bg-accent1 rounded-lg gap-2 my-2">
                    <div class="h-full flex flex-col justify-center content-center items-center p-2 gap-y-2">
                        <div class="flex gap-x-2 content-center items-center">
                            <button @click.stop="decrement(equip)" class="px-3 py-1 bg-secondary text-white h-8 w-8 rounded-full">-</button>
                            <input v-model="equip.selectedQuantity" class="text-center w-10 rounded-md" readonly>
                            <button @click.stop="increment(equip)" class="px-3 py-1 bg-accent3 text-white h-8 w-8 rounded-full">+</button>
                        </div>
                        <span class="text-accent3 font-bold">{{ equip.name }}</span>
                        <div class="flex justify-around w-full">
                            <span class="text-white">1 szt: {{ equip.hourly_rate }} zł</span>
                            <span class="text-white">suma: {{ equip.selectedQuantity * equip.hourly_rate }} zł</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="total-cost mt-4 p-4 border-t">
                <h3 class="text-lg font-bold text-accent3">Całkowita suma za sprzęt: {{ totalPrice }} zł</h3>
                <button @click.stop="finalizeReservation" class="mt-4 bg-accent1 text-white px-4 py-2 rounded-lg">Dodaj sprzęt</button>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Add necessary styles */
</style>
