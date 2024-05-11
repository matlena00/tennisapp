<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Aside from '@/Layouts/Aside.vue';
import MainContent from '@/Components/MainContent.vue';
import { defineProps, reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    reservation: Object,
});

const form = reactive({
    ...props.reservation,
});

const updateReservation = () => {
    console.log(form);
    Inertia.put(`/reservations/${form.id}`, form);
};

const deleteReservation = () => {
    if (confirm("Czy na pewno chcesz anulować tę rezerwację?")) {
        Inertia.delete(`/reservations/${form.id}`);
    }
};
</script>

<template>
    <AuthenticatedLayout></AuthenticatedLayout>
    <Aside></Aside>

    <MainContent>
        <h2 class="mb-8 text-3xl font-bold">Edycja rezerwacji</h2>
        <form @submit.prevent="updateReservation" class="max-w-6xl p-4 bg-primary rounded-md">
            <div class="flex flex-col gap-2 p-8">
                <input v-model="form.user.name" class="form-input mt-1 block w-full text-gray-800" type="text" disabled />
                <input v-model="form.user.first_name" class="form-input mt-1 block w-full text-gray-800" type="text" disabled />
                <input v-model="form.user.last_name" class="form-input mt-1 block w-full text-gray-800" type="text" disabled />
                <select v-model="form.status" class="form-select mt-1 block w-full text-gray-800" required>
                    <option value="scheduled">Zaplanowana</option>
                    <option value="completed">Zakończona</option>
                    <option value="canceled">Anulowana</option>
                </select>
                <input v-model="form.start_time" class="form-input mt-1 block w-full text-gray-800" type="datetime-local" required />
                <input v-model="form.end_time" class="form-input mt-1 block w-full text-gray-800" type="datetime-local" required />
                <div class="flex justify-between mt-6">
                    <button type="submit" class="bg-secondary text-white py-2 px-4 rounded-lg hover:bg-accent1">
                        Aktualizuj rezerwację
                    </button>
                </div>
            </div>
        </form>
    </MainContent>
</template>

<style scoped>
</style>
