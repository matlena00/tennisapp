<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Aside from "@/Layouts/Aside.vue";
import MainContent from "@/Components/MainContent.vue";
import {Head, Link} from "@inertiajs/vue3";
import DangerButton from "@/Components/DangerButton.vue";
import {Inertia} from "@inertiajs/inertia";

const props = defineProps({
    reservations: Array
});

const cancelReservation = (id) => {
    if (confirm("Czy na pewno chcesz anulować tę rezerwację?")) {
        Inertia.post(`/reservations/${id}/cancel`, {_method: 'post', _token: props.csrfToken});
    }
}

const canCancel = (startTime, status) => {
    if (status === 'canceled') return false;

    const reservationDate = new Date(startTime);
    const currentDate = new Date();
    currentDate.setHours(0, 0, 0, 0);
    return reservationDate > currentDate;
}

const translateStatus = (status) => {
    const statusTranslations = {
        'scheduled': 'Zaplanowana',
        'canceled': 'Anulowana',
        'completed': 'Zakończona'
    };
    return statusTranslations[status] || status;
}
</script>

<template>
    <Head title="Moje Rezerwacje" />
    <AuthenticatedLayout></AuthenticatedLayout>
    <Aside></Aside>

    <MainContent>
        <div class="flex flex-col gap-16 items-start">
            <h1 class="mb-6 text-3xl font-bold">Moje Rezerwacje</h1>
            <div v-if="reservations.length > 0">
                <table class="max-w-6xl w-full whitespace-nowrap bg-primary rounded-md">
                    <tr class="text-left font-bold">
                        <th class="pb-4 pt-6 px-6 text-xl">Nazwa kortu</th>
                        <th class="pb-4 pt-6 px-6 text-xl">Nawierzchnia</th>
                        <th class="pb-4 pt-6 px-6 text-xl">Od</th>
                        <th class="pb-4 pt-6 px-6 text-xl">Do</th>
                        <th class="pb-4 pt-6 px-6 text-xl">Status</th>
                        <th class="pb-4 pt-6 px-6 text-xl"></th>
                    </tr>
                    <tr v-for="reservation in reservations"
                        :class="{'grass': reservation.court.surface === 'grass', 'clay': reservation.court.surface === 'clay', 'hard': reservation.court.surface === 'hard'}"
                        class="p-4 m-4 hover:bg-accent1">
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
                            <div class="flex items-center px-6 py-4 focus:text-indigo-500">
                                <div v-if="reservation.status">
                                    {{ translateStatus(reservation.status) }}
                                </div>
                            </div>
                        </td>
                        <td>
                            <DangerButton class="ms-3" v-if="canCancel(reservation.start_time, reservation.status)" @click="cancelReservation(reservation.id)">
                                Rezygnuj
                            </DangerButton>
                        </td>
                    </tr>
                </table>
            </div>
            <div v-else>
                <span class="text-lg">Nie posiadasz jeszcze żadnych rezerwacji.</span>
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
