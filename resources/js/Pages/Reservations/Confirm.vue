<script setup>
import {defineProps, ref} from 'vue';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Aside from "@/Layouts/Aside.vue";
import MainContent from "@/Components/MainContent.vue";
import {usePage} from "@inertiajs/vue3";
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
    'user_id': user.id
})

const makeReservation = async () => {
    const start = moment(form.value.start_time).format('YYYY-MM-DD HH:mm:ss');
    const end = moment(form.value.end_time).format('YYYY-MM-DD HH:mm:ss');

    axios.post('/reservations', {
        'user_id': form.value.user_id,
        'court_id': props.court.id,
        'start_time': start,
        'end_time': end
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
        <form @submit.prevent="makeReservation" class="max-w-6xl p-4 bg-gray-800 rounded-md">
            <div class="flex flex-col gap-2 p-8">
                <input v-model="form.name" class="pb-4 pr-6 w-full rounded-md border-b border-gray-800 text-gray-800" label="Name" />
                <input v-model="form.start_time" class="text-gray-800" type="datetime-local" label="Opening Time">
                <input v-model="form.end_time" class="text-gray-800" type="datetime-local" label="Closing Time">
                <div class="flex justify-between">
                    <button class="mt-4 bg-white border-2 text-red-600 border-white w-fit  py-2 px-4 rounded-lg hover:underline" @click="route('/reservations/index')">Wróć</button>
                    <button class="mt-4 bg-gray-800 border-2 text-white border-white w-fit  py-2 px-4 rounded-lg hover:text-white hover:bg-green-500">Rezerwuj</button>
                </div>
            </div>
        </form>
    </MainContent>
</template>

<style scoped>

</style>
