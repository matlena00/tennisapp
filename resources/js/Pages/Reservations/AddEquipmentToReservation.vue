<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Aside from "@/Layouts/Aside.vue";
import MainContent from '@/Components/MainContent.vue';
import { defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    reservations: Array
});

</script>

<template>
    <AuthenticatedLayout></AuthenticatedLayout>
        <Aside></Aside>
        <MainContent>
            <h1 class="mb-2 text-3xl font-bold">Lista rezerwacji, dla których możesz wypożyczyć sprzęt</h1>
            <span class="block mb-8 text-md"></span>
            <div v-if="reservations.length > 0">
                <div class="flex flex-col gap-y-3 max-w-4xl">
                    <div v-for="reservation in reservations" :key="reservation.id" class="flex gap-x-4 justify-between items-center p-4 bg-accent2 rounded-md"
                         :class="{'grass': reservation.court.surface === 'grass', 'clay': reservation.court.surface === 'clay', 'hard': reservation.court.surface === 'hard'}"
                    >
                        <div>
                            <div>
                                <span class="font-bold">Kort:</span> {{ reservation.court.name }}
                            </div>
                            <div>
                                <span class="font-bold">Data:</span> {{ reservation.start_time }} - {{ reservation.end_time }}
                            </div>
                        </div>

                        <Link :href="`/reservations/${reservation.id}/add-equipment`" class="bg-accent3 text-secondary px-4 py-2 rounded-md w-fit h-fit font-bold">
                            Dodaj sprzęt do rezerwacji
                        </Link>
                    </div>
                </div>
            </div>
            <div v-else>
                <p>Nie masz żadnych przyszłych rezerwacji.</p>
                <Link href="/reserve" class="mt-4 bg-green-500 text-white px-4 py-2 rounded-md">Zarezerwuj kort</Link>
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
