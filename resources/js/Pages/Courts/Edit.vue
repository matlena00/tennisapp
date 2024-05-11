<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Aside from "@/Layouts/Aside.vue";
import MainContent from "@/Components/MainContent.vue";
import {defineProps, reactive} from "vue";
import {Inertia} from "@inertiajs/inertia";

const props = defineProps({
    court: Object,
});

const form = reactive({
    ...props.court
});
const updateCourt = () => {
    console.log(form);
    Inertia.put(`/courts/${form.id}`, form);
}

const deleteCourt = () => {
    if (confirm("Czy na pewno chcesz usunąć kort?")) {
        Inertia.delete(`/courts/${form.id}`);
    }
}
</script>

<template>
    <AuthenticatedLayout></AuthenticatedLayout>
    <Aside></Aside>
    <MainContent>
        <h2 class="mb-8 text-3xl font-bold">Edycja kortu</h2>
        <form @submit.prevent="updateCourt" class="max-w-6xl p-4 bg-primary rounded-md">
            <div class="flex flex-col gap-2 p-8">
                <input v-model="form.name" class="pb-4 pr-6 w-full rounded-md border-b border-gray-800 text-gray-800" label="Name" />
                <input v-model="form.description" class="pb-4 pr-6 w-full rounded-md border-b border-gray-800 text-gray-800" label="Description" />
                <input v-model="form.opening_time" class="text-gray-800" type="time" label="Opening Time">
                <input v-model="form.closing_time" class="text-gray-800" type="time" label="Closing Time">
                <select v-model="form.surface" class="pb-4 pr-6 w-full rounded-md border-b border-gray-800 text-gray-800" label="Surface">
                    <option value="hard">Twarda</option>
                    <option value="grass">Trawiasta</option>
                    <option value="clay">Mączka</option>
                </select>
                <input v-model="form.hourly_rate" class="text-gray-800" type="number" label="Hourly Rate" min="0">
                <div class="flex justify-between">
                    <button class="mt-4 bg-white border-2 text-red-600 border-white w-fit  py-2 px-4 rounded-lg hover:underline" @click="deleteCourt()">Usuń</button>
                    <button class="mt-4 bg-secondary text-white  w-fit  py-2 px-4 rounded-lg hover:text-white hover:bg-accent1">Aktualizuj kort</button>
                </div>
            </div>
        </form>
    </MainContent>
</template>

<style scoped>

</style>
