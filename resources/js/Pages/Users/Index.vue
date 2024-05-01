<script setup>
import { defineProps } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Aside from "@/Layouts/Aside.vue";
import { Link } from '@inertiajs/vue3'
import MainContent from "@/Components/MainContent.vue";
const props = defineProps({
    users: Array,
});
</script>

<template>
    <AuthenticatedLayout></AuthenticatedLayout>
    <Aside></Aside>

    <MainContent>
        <h1 class="mb-8 text-3xl font-bold">Użytkownicy</h1>
        <div class="max-w-6xl flex items-center justify-end mb-6">
            <Link class="px-6 py-3 bg-primary text-white rounded-md" href="/users/create">
                <span>Stwórz</span>
                <span class="hidden md:inline">&nbsp;nowego</span>
            </Link>
        </div>
        <table class="max-w-6xl w-full whitespace-nowrap bg-primary rounded-md">
            <tr class="text-left font-bold">
                <th class="pb-4 pt-6 px-6 text-xl">Imię</th>
                <th class="pb-4 pt-6 px-6 text-xl">Nazwisko</th>
                <th class="pb-4 pt-6 px-6 text-xl">Nick</th>
                <th class="pb-4 pt-6 px-6 text-xl">Email</th>
                <th class="pb-4 pt-6 px-6 text-xl">Telefon</th>
            </tr>
            <tr v-for="user in users"
                class="p-4 m-4 hover:bg-accent1">
                <td>
                    <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/users/${user.id}/edit`">
                        <div v-if="user.first_name">
                            {{ user.first_name }}
                        </div>
                    </Link>
                </td>
                <td>
                    <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/users/${user.id}/edit`">
                        <div v-if="user.last_name">
                            {{ user.last_name }}
                        </div>
                    </Link>
                </td>
                <td>
                    <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/users/${user.id}/edit`">
                        <div v-if="user.name">
                            {{ user.name }}
                        </div>
                    </Link>
                </td>
                <td>
                    <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/users/${user.id}/edit`">
                        <div v-if="user.email">
                            {{ user.email }}
                        </div>
                    </Link>
                </td>
                <td>
                    <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/users/${user.id}/edit`">
                        <div v-if="user.phone">
                            {{ user.phone }}
                        </div>
                    </Link>
                </td>
            </tr>
        </table>
    </MainContent>
</template>

<style scoped>

</style>
