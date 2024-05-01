<script setup>
import { defineProps } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Aside from "@/Layouts/Aside.vue";
import MainContent from "@/Components/MainContent.vue";
import {Head, Link} from "@inertiajs/vue3";
import DangerButton from "@/Components/DangerButton.vue";

const props = defineProps({
    user: Object,
    courts: Array,
    reservations: Array
});

const translateSurface = (surface) => {
    const surfaces = {
        'grass': 'Trawiasta',
        'clay': 'Mączka',
        'hard': 'Twarda'
    };
    return surfaces[surface] || 'Nieznana';
};
</script>

<template>
    <Head title="Rezerwacja kortu" />
    <AuthenticatedLayout></AuthenticatedLayout>
    <Aside></Aside>
    <MainContent>
        <div v-if="user.role === 'admin'">
            <h1 class="mb-8 text-3xl font-bold">Rezerwacje</h1>
            <table class="max-w-6xl w-full whitespace-nowrap bg-primary rounded-md">
                <tr class="text-left font-bold">
                    <th class="pb-4 pt-6 px-6 text-xl">Użytkownik</th>
                    <th class="pb-4 pt-6 px-6 text-xl">Nazwa kortu</th>
                    <th class="pb-4 pt-6 px-6 text-xl">Nawierzchnia</th>
                    <th class="pb-4 pt-6 px-6 text-xl">Od</th>
                    <th class="pb-4 pt-6 px-6 text-xl">Do</th>
                </tr>
                <tr v-for="reservation in reservations"
                    :class="{'grass': reservation.court.surface === 'grass', 'clay': reservation.court.surface === 'clay', 'hard': reservation.court.surface === 'hard'}"
                    class="p-4 m-4 hover:bg-accent1">
                    <td>
                        <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/reservations/${reservation.id}/edit`">
                            <div v-if="reservation.user.name">
                                {{ reservation.user.name }}
                            </div>
                        </Link>
                    </td>
                    <td>
                        <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/reservations/${reservation.id}/edit`">
                            <div v-if="reservation.court.name">
                                {{ reservation.court.name }}
                            </div>
                        </Link>
                    </td>
                    <td>
                        <Link class="flex items-center px-6 py-4 focus:text-indigo-500">
                            <div v-if="reservation.court.surface">
                                {{ translateSurface(reservation.court.surface) }}
                            </div>
                        </Link>
                    </td>
                    <td>
                        <Link class="flex items-center px-6 py-4 focus:text-indigo-500">
                            <div v-if="reservation.start_time">
                                {{ reservation.start_time }}
                            </div>
                        </Link>
                    </td>
                    <td>
                        <Link class="flex items-center px-6 py-4 focus:text-indigo-500">
                            <div v-if="reservation.end_time">
                                {{ reservation.end_time }}
                            </div>
                        </Link>
                    </td>
                </tr>
            </table>
        </div>
        <div v-else>
            <h1 class="mb-8 text-3xl font-bold">Rezerwuj swój ulubiony kort!</h1>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 gap-8 lg:grid-cols-3">
                <div v-for="court in courts" :key="court.id">
                    <Link :href="`/reserve/${court.id}`" :class="{'grass': court.surface === 'grass', 'clay': court.surface === 'clay', 'hard': court.surface === 'hard'}"
                          class="flex flex-col w-full px-6 py-4 rounded-md text-white opacity-85 hover:opacity-100">
                        <h3 class="font-bold text-2xl mb-2">{{court.name}}</h3>
                        <p class="mb-4">{{court.description}}</p>
                        <p class="">Otwarcie: {{court.opening_time}}</p>
                        <p class="">Zamknięcie: {{court.closing_time}}</p>
                        <span class="p-4 mt-3 text-white bg-primary w-fit rounded-md">Cena za 1h: {{court.hourly_rate}} zł</span>
                    </Link>
                </div>
            </div>
        </div>
    </MainContent>
</template>

<style scoped>
.grass {
    background-color: #339966;
}
.clay {
    background-color: #993300;
}
.hard {
    background-color: #336699;
}
</style>
