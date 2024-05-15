<script setup>
import {defineProps, onMounted, ref, watch} from 'vue';
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

const showAvailableSlots = () => {
    axios.get(`/courts/${props.court.id}/slots`)
        .then(response => {
            if (response.data) {
                events.value = response.data;
            }
        })
        .catch(error => {
            console.error('Error fetching available slots:', error);
        });
}

const events = ref([]);

const reservationConfirmation = (clickInfo) => {
    const { startStr: start, endStr: end } = clickInfo.event;
    const courtId = props.court.id;

    const startTime = moment(start);
    const endTime = moment(end);
    const duration = endTime.diff(startTime, 'hours', true);

    const totalPrice = duration * props.court.hourly_rate;

    window.location.href = `/reservation/confirm/${courtId}/${start}/${end}/${totalPrice.toFixed(2)}`;
}

const calendarOptions = ref({
    plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
    initialView: 'timeGridWeek',
    events: events.value,
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
    eventClick: function(clickInfo) {
        reservationConfirmation(clickInfo);
        console.log(clickInfo.event._instance.range);
    }
});

watch(events, (newEvents) => {
    calendarOptions.value.events = newEvents;
}, { deep: true });

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
