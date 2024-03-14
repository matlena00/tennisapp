<script setup>
import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Aside from "@/Layouts/Aside.vue";

const form = reactive({
    name: null,
    description: null,
    surface: null,
    available: null
})

function submit() {
    console.log('Wysylam');
    console.log(form);
    router.post('/courts', form)
}
</script>

<template>
    <AuthenticatedLayout></AuthenticatedLayout>
    <Aside></Aside>
    <div class="ml-[256px] p-8 bg-gray-100 w-auto h-[calc(100vh-64px)]">
        <h2 class="mb-8 text-3xl text-gray-800 font-bold">Dodaj nowy kort</h2>
        <form @submit.prevent="submit" class="max-w-6xl p-4 bg-white rounded-md">
            <div class="flex flex-col gap-2 p-8">
                <input v-model="form.name" class="pb-4 pr-6 w-full rounded-md border-b border-gray-800" label="Name" />
                <input v-model="form.description" class="pb-4 pr-6 w-full rounded-md border-b border-gray-800" label="Description" />
                <select v-model="form.surface" class="pb-4 pr-6 w-full rounded-md border-b border-gray-800" label="Surface">
                    <option value="hard">Twarda</option>
                    <option value="grass">Trawiasta</option>
                    <option value="clay">Mączka</option>
                </select>
                <button class="mt-4 bg-gray-800 border-2 text-white border-white w-fit mx-auto py-2 px-4 rounded-lg">Dodaj kort</button>
            </div>
        </form>
    </div>
</template>

<style scoped>

</style>
