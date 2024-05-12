<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Aside from '@/Layouts/Aside.vue';
import MainContent from '@/Components/MainContent.vue';
import { defineProps, reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    user: Object,
});

const form = reactive({
    ...props.user,
});

const updateUser = () => {
    console.log(form);
    Inertia.put(`/users/${form.id}`, form);
};

const deleteReservation = () => {
    if (confirm("Czy na pewno chcesz anulować tę rezerwację?")) {
        Inertia.delete(`/users/${form.id}`);
    }
};
</script>

<template>
    <AuthenticatedLayout></AuthenticatedLayout>
    <Aside></Aside>

    <MainContent>
        <h2 class="mb-8 text-3xl font-bold">Edycja użytkownika</h2>
        <form @submit.prevent="updateUser" class="max-w-6xl p-4 bg-primary rounded-md">
            <div class="flex flex-col gap-2 p-8">
                <input v-model="form.first_name" class="form-input mt-1 block w-full text-gray-800" type="text"  />
                <input v-model="form.last_name" class="form-input mt-1 block w-full text-gray-800" type="text"  />
                <input v-model="form.email" class="form-input mt-1 block w-full text-gray-800" type="email"  />
                <input v-model="form.phone" class="form-input mt-1 block w-full text-gray-800" type="tel"  />
                <input v-model="form.name" class="form-input mt-1 block w-full text-gray-800" type="text"  />
                <div class="flex justify-between mt-6">
                    <button type="submit" class="bg-secondary text-white py-2 px-4 rounded-lg hover:bg-accent1">
                        Aktualizuj użytkownika
                    </button>
                </div>
            </div>
        </form>
    </MainContent>
</template>

<style scoped>
</style>

