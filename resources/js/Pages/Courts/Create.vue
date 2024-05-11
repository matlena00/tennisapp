<script setup>
import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Aside from "@/Layouts/Aside.vue";
import MainContent from "@/Components/MainContent.vue";

const form = reactive({
    name: null,
    description: null,
    opening_time: null,
    closing_time: null,
    surface: null,
    hourly_rate: null,
    available: null
})

const createCourt = () => {
    console.log('Wysylam');
    console.log(form);
    router.post('/courts', form)

}

defineProps({
    isAdmin: Boolean
})
</script>

<template>
    <AuthenticatedLayout></AuthenticatedLayout>
    <Aside></Aside>

    <MainContent>
        <h2 class="mb-8 text-3xl text-white">Dodaj nowy kort</h2>
        <form @submit.prevent="createCourt" class="max-w-6xl p-4 bg-primary rounded-md">
            <div class="flex flex-col gap-2 p-8 text-gray-800">
                <input v-model="form.name" class="pr-6 w-full rounded-md border-b border-gray-800 text-gray-800" label="Name" placeholder="Nazwa kortu"/>
                <input v-model="form.description" class="pr-6 w-full rounded-md border-b border-gray-800 text-gray-800" label="Description" placeholder="Opis"/>
                <input v-model="form.opening_time" class="text-gray-800" type="time" label="Opening Time">
                <input v-model="form.closing_time" class="text-gray-800" type="time" label="Closing Time">
                <select v-model="form.surface" class="pr-6 w-full rounded-md border-b border-gray-800 text-gray-800" label="Surface">
                    <option value="hard" selected>Twarda</option>
                    <option value="grass">Trawiasta</option>
                    <option value="clay">Mączka</option>
                </select>
                <input v-model="form.hourly_rate" class="text-gray-800" type="number" label="Hourly Rate" min="0" placeholder="Stawka za godzinę">
                <button class="mt-4 bg-primary border-2 text-white border-white w-fit mx-auto py-2 px-4 rounded-lg">Dodaj kort</button>
            </div>
        </form>
    </MainContent>
</template>

<style scoped>

</style>
