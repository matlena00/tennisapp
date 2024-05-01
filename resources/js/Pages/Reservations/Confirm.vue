<script setup>
import {defineProps, ref} from 'vue';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Aside from "@/Layouts/Aside.vue";
import MainContent from "@/Components/MainContent.vue";
import {router, usePage} from "@inertiajs/vue3";
import moment from 'moment';
import {data} from "autoprefixer";

const props = defineProps({
    court: Object,
    date: String,
    start_time: String,
    end_time: String,
    user_id: Number
})

const user = usePage().props.auth.user;
const form = ref({
    ...props.court,
    'start_time': props.start_time,
    'end_time': props.end_time,
    'user_id': user.id,
    'user_email': user.email,
    'equipment': []
})

const availableEquipment = ref([]);
const selectedEquipment = ref([]);

const loadAvailableEquipments = async (start, end) => {
    const startDate = moment(form.value.start_time).format('YYYY-MM-DD HH:mm:ss');
    const endDate = moment(form.value.end_time).format('YYYY-MM-DD HH:mm:ss');

    axios.get('/api/equipment/available', {
        start_time: startDate,
        end_time: endDate
    }).then(response => {
        if (response.data) {
            availableEquipment.value = response.data.map(equip => ({
                ...equip,
                selectedQuantity: 0
            }));
        }
    }).catch(error => {
        console.error('Error fetching available equipment:', error);
    });
}

const addToReservation = (equipment) => {
    if (equipment.selectedQuantity > 0 && equipment.selectedQuantity <= 4) {
        const index = form.value.equipment.findIndex(item => item.id === equipment.id);
        if (index === -1) {
            form.value.equipment.push({
                id: equipment.id,
                quantity: equipment.selectedQuantity
            });
        } else {
            form.value.equipment[index].quantity = equipment.selectedQuantity;
        }
    }
};

const getEquipmentName = (id) => {
    const item = availableEquipment.value.find(e => e.id === id);
    return item ? item.name : 'Unknown';
};

const getEquipmentRate = (id) => {
    const item = availableEquipment.value.find(e => e.id === id);
    return item ? item.hourly_rate : 0;
};


const makeReservation = async () => {
    const start = moment(form.value.start_time).format('YYYY-MM-DD HH:mm:ss');
    const end = moment(form.value.end_time).format('YYYY-MM-DD HH:mm:ss');

    axios.post('/reservations', {
        'user_id': form.value.user_id,
        'user_email': form.value.user_email,
        'court_id': props.court.id,
        'start_time': start,
        'end_time': end,
        'equipment': form.value.equipment
    })
    .then(response => {
        if (response.data) {
            console.log(data);
        }
    })
    .catch(error => {
        console.error('Error fetching available slots:', error);
    })
}
</script>

<template>
    <AuthenticatedLayout></AuthenticatedLayout>
    <Aside></Aside>
    <MainContent>
        <h1 class="mb-8 text-3xl font-bold">Sprawdź poprawność danych i kliknij przycisk Rezerwuj w celu dokonania rezerwacji</h1>
        <form @submit.prevent="makeReservation()" class="max-w-6xl p-4 bg-gray-800 rounded-md">
            <div class="flex flex-col gap-2 p-8">
                <input v-model="form.name" class="pb-4 pr-6 w-full rounded-md border-b border-gray-800 text-gray-800" label="Name" />
                <input v-model="form.start_time" class="text-gray-800" type="datetime-local" label="Opening Time">
                <input v-model="form.end_time" class="text-gray-800" type="datetime-local" label="Closing Time">
                <div v-if="form.equipment.length > 0" class="mt-6 bg-blue-600 p-4 rounded-md">
                    <h3 class="text-xl font-bold mb-4">Dodatkowy sprzęt:</h3>
                    <div v-for="item in form.equipment" :key="item.id" class="py-2">
                        <span class="font-semibold">{{ getEquipmentName(item.id) }} | </span>
                        <span> Liczba sztuk: {{ item.quantity }} | </span>
                        <span> Cena za godzinę: {{ getEquipmentRate(item.id) }} zł</span>
                    </div>
                </div>
                <div class="flex justify-between">
                    <button class="mt-4 bg-white border-2 text-red-600 border-white w-fit  py-2 px-4 rounded-lg hover:underline" @click="route('/reservations/index')">Wróć</button>
                    <button class="mt-4 bg-gray-800 border-2 text-white border-white w-fit  py-2 px-4 rounded-lg hover:text-white hover:bg-green-500">Rezerwuj</button>
                </div>
                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div v-for="equipment in availableEquipment" :key="equipment.id" class="p-4 bg-gray-700 rounded-md">
                        <h3 class="text-white font-bold">{{ equipment.name }}</h3>
                        <p class="text-gray-300">{{ equipment.description }}</p>
                        <p class="text-gray-300">{{ equipment.hourly_rate }}</p>
                        <input type="number" v-model.number="equipment.selectedQuantity" :max="4" min="0" value="1" class="w-full mt-2 p-1 rounded-md text-gray-800" />
                        <div class="mt-2">
                            <button @click="addToReservation(equipment)" type="button" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">Dodaj do rezerwacji</button>
                        </div>
                    </div>
                </div>
                <div @click="loadAvailableEquipments(form.start_time, form.end_time)">Dodaj sprzęt</div>
            </div>
        </form>
    </MainContent>
</template>

<style scoped>

</style>
