<script setup>
import { defineProps } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Aside from "@/Layouts/Aside.vue";
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    courts: Array,
});
</script>

<template>
    <AuthenticatedLayout></AuthenticatedLayout>
    <Aside></Aside>
    <div class="ml-[256px] p-4">
        <h1 class="mb-8 text-3xl font-bold">Contacts</h1>
        <div class="flex items-center justify-end mb-6">
            <Link class="btn-indigo" href="/courts/create">
                <span>Create</span>
                <span class="hidden md:inline">&nbsp;Court</span>
            </Link>
        </div>
        <table class="w-full whitespace-nowrap">
            <tr class="text-left font-bold">
                <th class="pb-4 pt-6 px-6">Nazwa</th>
                <th class="pb-4 pt-6 px-6">Opis</th>
                <th class="pb-4 pt-6 px-6">Nawierzchnia</th>
            </tr>
            <tr v-for="court in courts"
                class="p-4 m-4 hover:bg-gray-100">
                <td>
                    <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/courts/${court.id}/edit`">
                        <div v-if="court.name">
                            {{ court.name }}
                        </div>
                    </Link>
                </td>
                <td>
                    <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/courts/${court.id}/edit`">
                        <div v-if="court.description">
                            {{ court.description }}
                        </div>
                    </Link>
                </td><td>
                <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/courts/${court.id}/edit`">
                    <div v-if="court.surface">
                        {{ court.surface }}
                    </div>
                </Link>
            </td>
            </tr>
        </table>
    </div>


</template>

<style scoped>

</style>
