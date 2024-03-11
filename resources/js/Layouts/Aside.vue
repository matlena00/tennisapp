<script setup>

import {Link} from "@inertiajs/vue3";
</script>

<template>
    <aside class="w-[256px] fixed left-0 h-full bg-gray-800">
        <div class="flex flex-col gap-y-2 mt-4 px-4">
            <Link
                href="#"
                class="text-white rounded-md hover:bg-gray-700 p-2 mt-4"
            >
                Dashboard
            </Link>
            <Link
                href="#"
                class="text-white rounded-md hover:bg-gray-700 p-2"
            >
                Rezerwuj kort
            </Link>
            <Link
                href="#"
                class="text-white rounded-md hover:bg-gray-700 p-2"
            >
                Wypożycz sprzęt
            </Link>
            <Link
                href="#"
                class="text-white rounded-md hover:bg-gray-700 p-2"
            >
                Moje rezerwacje
            </Link>
            <Link
                href="#"
                class="text-white rounded-md hover:bg-gray-700 p-2"
            >
                Powiadomienia
            </Link>
            <Link
                href="#"
                class="text-white rounded-md hover:bg-gray-700 p-2"
            >
                Profil
            </Link>
        </div>
    </aside>
</template>

<style scoped>

</style>
