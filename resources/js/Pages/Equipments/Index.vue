<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import MainContent from "@/Components/MainContent.vue";
import {Link} from "@inertiajs/vue3";
import Aside from "@/Layouts/Aside.vue";
import {defineProps} from "vue";
const props = defineProps({
    equipments: Array,
});
</script>

<template>
    <AuthenticatedLayout></AuthenticatedLayout>
    <Aside></Aside>

    <MainContent>
        <h1 class="mb-8 text-3xl font-bold">Wszystkie Sprzęty</h1>
        <div class="max-w-6xl flex items-center justify-end mb-6">
            <Link class="px-6 py-3 bg-gray-800 text-white rounded-md" href="/equipments/create">
                <span>Stwórz</span>
                <span class="hidden md:inline">&nbsp;nowy</span>
            </Link>
        </div>
        <table class="max-w-6xl w-full whitespace-nowrap bg-gray-800 rounded-md">
            <tr class="text-left font-bold">
                <th class="pb-4 pt-6 px-6 text-xl">Nazwa</th>
                <th class="pb-4 pt-6 px-6 text-xl">Opis</th>
                <th class="pb-4 pt-6 px-6 text-xl">Cena za h</th>
                <th class="pb-4 pt-6 px-6 text-xl">Ilość</th>
            </tr>
            <tr v-for="equipment in equipments"
                class="p-4 m-4 hover:bg-gray-500">
                <td>
                    <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/equipments/${equipment.id}/edit`">
                        <div v-if="equipment.name">
                            {{ equipment.name }}
                        </div>
                    </Link>
                </td>
                <td>
                    <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/equipments/${equipment.id}/edit`">
                        <div v-if="equipment.description">
                            {{ equipment.description }}
                        </div>
                    </Link>
                </td>
                <td>
                    <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/equipments/${equipment.id}/edit`">
                        <div v-if="equipment.hourly_rate">
                            {{ equipment.hourly_rate }} zł
                        </div>
                    </Link>
                </td>
                <td>
                    <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/equipments/${equipment.id}/edit`">
                        <div v-if="equipment.hourly_rate">
                            {{ equipment.quantity }}
                        </div>
                    </Link>
                </td>
            </tr>
        </table>
    </MainContent>
</template>

<style scoped>

</style>
