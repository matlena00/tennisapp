<script setup>
import { defineProps, onMounted, ref, watch } from 'vue';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Aside from "@/Layouts/Aside.vue";
import MainContent from '@/Components/MainContent.vue';
import FullCalendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import moment from 'moment';

const props = defineProps({
    court: Object,
});

const today = new Date().toISOString().slice(0, 10);

const showOccupiedSlots = () => {
    axios.get(`/courts/${props.court.id}/slots`)
        .then(response => {
            if (response.data) {
                events.value = response.data;
            }
        })
        .catch(error => {
            console.error('Error fetching occupied slots:', error);
        });
};

const events = ref([]);

const reservationConfirmation = (start, end) => {
    const courtId = props.court.id;
    const startTime = moment(start).format('YYYY-MM-DDTHH:mm:ss');
    const endTime = moment(end).format('YYYY-MM-DDTHH:mm:ss');
    const duration = moment(end).diff(moment(start), 'hours', true);
    const totalPrice = duration * props.court.hourly_rate;

    window.location.href = `/reservation/confirm/${courtId}/${startTime}/${endTime}/${totalPrice.toFixed(2)}`;
};

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
    contentHeight: 'auto',
    selectConstraint: {
        start: moment().startOf('hour').add(1, 'hour').toISOString(), // Ograniczenie wyboru do przyszłych godzin od następnej pełnej godziny
    },
    validRange: {
        start: moment().startOf('hour').add(1, 'hour').toISOString(), // Ograniczenie wyświetlania do przyszłych godzin od następnej pełnej godziny
    },
    select: function(info) {
        const start = moment(info.startStr).format('HH:mm');
        const end = moment(info.endStr).format('HH:mm');

        if (confirm('Czy na pewno chcesz kontynuować rezerwację kortu w godzinach: ' + start + ' - ' + end + ' ?')) {
            reservationConfirmation(info.startStr, info.endStr);
        }
    },
    eventClick: function(clickInfo) {
        const start = clickInfo.event.start;
        const end = clickInfo.event.end;

        reservationConfirmation(start, end);
    },
    eventClassNames: function() {
        return ['custom-event-class'];
    }
});

watch(events, (newEvents) => {
    calendarOptions.value.events = newEvents;
}, { deep: true });

onMounted(() => {
    showOccupiedSlots();
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
