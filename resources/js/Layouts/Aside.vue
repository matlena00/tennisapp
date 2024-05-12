<script setup>
import {Link} from "@inertiajs/vue3";
</script>

<template>
    <aside class="w-[256px] fixed left-0 h-full bg-primary">
        <div class="flex flex-col gap-y-2 mt-4 px-4">
            <Link
                href="/dashboard"
                class="text-white rounded-md hover:bg-secondary p-2 mt-4"
            >
                Dashboard
            </Link>
            <Link
                v-if="$page.props.auth.user.role == 'user'"
                href="/reservations/index"
                class="text-white rounded-md hover:bg-secondary p-2"
            >
                Rezerwuj kort
            </Link>
            <Link
                v-if="$page.props.auth.user.role == 'user'"
                href="#"
                class="text-white rounded-md hover:bg-secondary p-2"
            >
                Wypożycz sprzęt
            </Link>
            <Link
                v-if="$page.props.auth.user.role == 'user'"
                href="/my-reservations"
                class="text-white rounded-md hover:bg-secondary p-2"
            >
                Moje rezerwacje
            </Link>
            <Link
                v-if="$page.props.auth.user.role == 'admin'"
                href="/reservations"
                class="text-white rounded-md hover:bg-secondary p-2"
            >
                Rezerwacje
            </Link>
            <Link
                v-if="$page.props.auth.user.role == 'admin'"
                href="/courts"
                class="text-white rounded-md hover:bg-secondary p-2"
            >
                Korty
            </Link>
            <Link
                v-if="$page.props.auth.user.role == 'admin'"
                href="/equipments"
                class="text-white rounded-md hover:bg-secondary p-2"
            >
                Wyposażenie
            </Link>
            <Link
                v-if="$page.props.auth.user.role == 'admin'"
                href="/users"
                class="text-white rounded-md hover:bg-secondary p-2"
            >
                Użytkownicy
            </Link>
            <Link
                href="/profile"
                class="text-white rounded-md hover:bg-secondary p-2"
            >
                Profil
            </Link>
        </div>
    </aside>
</template>

<style scoped>

</style>
