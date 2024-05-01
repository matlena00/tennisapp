<script setup xmlns:hover="http://www.w3.org/1999/xhtml">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Aside from '@/Layouts/Aside.vue';
import MainContent from "@/Components/MainContent.vue";
import {Head, Link} from '@inertiajs/vue3';
import DangerButton from "@/Components/DangerButton.vue";
import {Inertia} from "@inertiajs/inertia";

const props = defineProps({
    reservations: Array,
    totalHours: Number
});

const deleteReservation = (reservationId) => {
    if (confirm("Czy na pewno chcesz anulować tę rezerwację?")) {
        Inertia.delete(`/reservations/${reservationId}`);
    }
}
</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout></AuthenticatedLayout>
    <Aside></Aside>

    <MainContent>
        <div class="flex flex-col gap-16">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-x-4 gap-y-6 max-w-6xl">
                <div class="bg-green-600 text-white font-bold text-2xl text-center p-8 rounded-xl">
                    Liczba rezerwacji
                    <span class="block text-center text-4xl">{{ reservations.length }}</span>
                </div>
                <div class="bg-orange-400 text-white font-bold text-2xl text-center p-8 rounded-xl">
                    Godziny na korcie
                    <span class="block text-center text-4xl">{{ totalHours }}</span>
                </div>
                <div class="bg-blue-500 text-white font-bold text-2xl text-center p-8 rounded-xl">
                    Najbliższa rezerwacja
                    <span class="block text-center text-4xl">{{ reservations.length }}</span>
                </div>
            </div>
            <div class="grid sm:grid-cols-1">
                <h2 class="mb-8 text-3xl font-bold">Ostatnie rezerwacje</h2>
                <div v-if="reservations.length > 0">
                    <table class="max-w-6xl w-full whitespace-nowrap bg-primary rounded-md">
                        <tr class="text-left font-bold">
                            <th class="pb-4 pt-6 px-6 text-xl">Nazwa kortu</th>
                            <th class="pb-4 pt-6 px-6 text-xl">Nawierzchnia</th>
                            <th class="pb-4 pt-6 px-6 text-xl">Od</th>
                            <th class="pb-4 pt-6 px-6 text-xl">Do</th>
                            <th class="pb-4 pt-6 px-6 text-xl"></th>
                        </tr>
                        <tr v-for="reservation in reservations"
                            :class="{'grass': reservation.court.surface === 'grass', 'clay': reservation.court.surface === 'clay', 'hard': reservation.court.surface === 'hard'}"
                            class="p-4 m-4 hover:bg-gray-500">
                            <td>
                                <div class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/reservations/${reservation.id}/edit`">
                                    <div v-if="reservation.court.name">
                                        {{ reservation.court.name }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center px-6 py-4 focus:text-indigo-500">
                                    <div v-if="reservation.court.surface">
                                        {{ reservation.court.surface }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center px-6 py-4 focus:text-indigo-500">
                                    <div v-if="reservation.start_time">
                                        {{ reservation.start_time }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center px-6 py-4 focus:text-indigo-500">
                                    <div v-if="reservation.end_time">
                                        {{ reservation.end_time }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <DangerButton class="ms-3" @click="deleteReservation(reservation.id)">
                                    Rezygnuj
                                </DangerButton>
                            </td>
                        </tr>
                    </table>
                </div>
                <div v-else>
                    <span>Nie posiadasz jeszcze żadnych rezerwacji.</span>
                    <Link href="/reservations/index" class="text-white rounded-md hover:bg-secondary p-2"> </Link>
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
