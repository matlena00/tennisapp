<script setup>
import { router } from '@inertiajs/vue3'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import MainContent from "@/Components/MainContent.vue";
import Aside from "@/Layouts/Aside.vue";
import {reactive} from "vue";

const form = reactive({
    name: null,
    description: null,
    hourly_rate: null,
    quantity: null,
    available: true
})

const createEquipment = () => {
    router.post('/equipments', form)
}
</script>

<template>
    <AuthenticatedLayout></AuthenticatedLayout>
    <Aside></Aside>

    <MainContent>
        <h2 class="mb-8 text-3xl text-white">Dodaj nowy sprzęt</h2>
        <form @submit.prevent="createEquipment()" class="max-w-6xl p-4 bg-primary rounded-md">
            <div class="flex flex-col gap-2 p-8 text-gray-800">
                <input v-model="form.name" class="pr-6 w-full rounded-md border-b border-gray-800" label="Name" placeholder="Nazwa sprzętu" />
                <input v-model="form.description" class="pr-6 w-full rounded-md border-b border-gray-800" label="Description" placeholder="Opis" />
                <input v-model="form.hourly_rate" class="rounded-md border-b border-gray-800" type="number" label="Hourly Rate" min="0" placeholder="Stawka za 1h">
                <input v-model="form.quantity" class="rounded-md border-b border-gray-800" type="number" label="Hourly Rate" min="0" placeholder="Ilość">
                <button class="mt-4 bg-primary border-2 text-white border-white w-fit mx-auto py-2 px-4 rounded-lg">Dodaj sprzęt</button>
            </div>
        </form>
    </MainContent>
</template>

<style scoped>

</style>
