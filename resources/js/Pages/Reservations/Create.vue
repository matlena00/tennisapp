<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Aside from "@/Layouts/Aside.vue";
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction';

defineProps({
    court: Array,
})

const today = new Date().toISOString().slice(0, 10);
const calendarOptions = {
    plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
    initialView: 'timeGridWeek',
    events: [
        // Example events
        { title: 'Rezerwacja', start: '2024-04-19T09:00:00', end: '2024-04-19T11:00:00' },
        { title: 'Rezerwacja', start: '2024-04-19T12:00:00', end: '2024-04-19T14:00:00' },
        { title: 'Rezerwacja', start: '2024-04-19T15:00:00', end: '2024-04-19T17:00:00' },
        { title: 'Rezerwacja', start: '2024-04-19T18:00:00', end: '2024-04-19T20:00:00' },
        { title: 'Rezerwacja', start: '2024-04-20T09:00:00', end: '2024-04-20T11:00:00' },
        { title: 'Rezerwacja', start: '2024-04-20T12:00:00', end: '2024-04-20T14:00:00' },
        { title: 'Rezerwacja', start: '2024-04-20T15:00:00', end: '2024-04-20T17:00:00' },
        { title: 'Rezerwacja', start: '2024-04-20T18:00:00', end: '2024-04-20T20:00:00' },
        { title: 'Rezerwacja', start: '2024-04-21T09:00:00', end: '2024-04-21T11:00:00' },
        { title: 'Rezerwacja', start: '2024-04-21T12:00:00', end: '2024-04-21T14:00:00' },
        { title: 'Rezerwacja', start: '2024-04-21T15:00:00', end: '2024-04-21T17:00:00' },
        { title: 'Rezerwacja', start: '2024-04-21T18:00:00', end: '2024-04-21T20:00:00' },
        { title: 'Rezerwacja', start: '2024-04-22T09:00:00', end: '2024-04-22T11:00:00' },
        { title: 'Rezerwacja', start: '2024-04-22T12:00:00', end: '2024-04-22T14:00:00' },
        { title: 'Rezerwacja', start: '2024-04-22T15:00:00', end: '2024-04-22T17:00:00' },
        { title: 'Rezerwacja', start: '2024-04-22T18:00:00', end: '2024-04-22T20:00:00' },
        { title: 'Rezerwacja', start: '2024-04-23T09:00:00', end: '2024-04-23T11:00:00' },
        { title: 'Rezerwacja', start: '2024-04-23T12:00:00', end: '2024-04-23T14:00:00' },
        { title: 'Rezerwacja', start: '2024-04-23T15:00:00', end: '2024-04-23T17:00:00' },
        { title: 'Rezerwacja', start: '2024-04-23T18:00:00', end: '2024-04-23T20:00:00' },
        { title: 'Rezerwacja', start: '2024-04-24T09:00:00', end: '2024-04-24T11:00:00' },
        { title: 'Rezerwacja', start: '2024-04-24T12:00:00', end: '2024-04-24T14:00:00' },
        { title: 'Rezerwacja', start: '2024-04-24T15:00:00', end: '2024-04-24T17:00:00' },
        { title: 'Rezerwacja', start: '2024-04-24T18:00:00', end: '2024-04-24T20:00:00' },
        { title: 'Rezerwacja', start: '2024-04-25T09:00:00', end: '2024-04-25T11:00:00' },
        { title: 'Rezerwacja', start: '2024-04-25T12:00:00', end: '2024-04-25T14:00:00' },
        { title: 'Rezerwacja', start: '2024-04-25T15:00:00', end: '2024-04-25T17:00:00' },
        { title: 'Rezerwacja', start: '2024-04-25T18:00:00', end: '2024-04-25T20:00:00' }
    ],
    allDaySlot: false,
    firstDay: 1,
    initialDate: today,
    slotMinTime: '08:00:00',
    slotMaxTime: '22:00:00',
    slotDuration: '01:00:00',
    slotLabelFormat: {
        hour: '2-digit',
        minute: '2-digit',
        hour12: false
        },
    selectable: true,
    dateClick: function(info) {
        alert('Clicked on: ' + info.dateStr);
        console.log(info)
    },
};
</script>

<template>
    <AuthenticatedLayout></AuthenticatedLayout>
    <Aside></Aside>

    <main class="ml-[256px] md:p-6 lg:p-12 bg-gray-100 h-[calc(100vh-64px)]">
        <h1 class="mb-8 text-3xl font-bold">Wybierz godzinę rezerwacji z dostępnych slotów</h1>
        <FullCalendar :options="calendarOptions" />
    </main>
</template>

<style scoped>
.fc {
    max-height: 100%;
}
</style>