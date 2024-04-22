<script setup>
import { defineProps, onMounted } from 'vue';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Aside from "@/Layouts/Aside.vue";
import MainContent from "@/Components/MainContent.vue";
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction';
import moment from 'moment';

const props = defineProps({
    court: Array,
})

const today = new Date().toISOString().slice(0, 10);

const calculateDuration = (start, end) => {
    const startDate = moment(start);
    const endDate = moment(end);
    const duration = moment.duration(endDate.diff(startDate));
    return duration.asHours();
}

const showAvailableSlots = () => {
    axios.get(`/courts/${props.court.id}/slots`)
        .then(response => {
            console.log(response);
        })
}
const showReservationModal = (x,y) => {
    alert(x)
}

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
    locale: 'pl',
    timeZone: 'Europe/Warsaw',
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
    select: function(info) {
        const duration = calculateDuration(info.start, info.end);
        if (duration > 14) {
            alert('Nie można zarezerwować kortów na więcej niż 1 dzień');
            return;
        }
        showReservationModal(info.start, info.end);
    }
};

onMounted(() => {
    showAvailableSlots();
});
</script>

<template>
    <AuthenticatedLayout></AuthenticatedLayout>
    <Aside></Aside>

    <MainContent>
        <h1 class="mb-8 text-3xl font-bold">Wybierz godzinę rezerwacji z dostępnych slotów</h1>
        <FullCalendar :options="calendarOptions" />
    </MainContent>
</template>

<style scoped>
.fc {
    max-height: 100%;
}
</style>
