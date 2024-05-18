<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

</script>

<template>
    <Head title="Welcome" />
    <nav class="bg-primary h-20 p-4 flex justify-center">
        <div class="flex gap-4">
            <Link :href="route('welcome')"
                  class="flex flex-row gap-3 items-center">
                <ApplicationLogo
                    class="text-white"
                />
                <p class="text-white font-bold text-3xl ml-[-160px]">tenisso</p>
            </Link>
        </div>
    </nav>
    <div class="grid grid-cols-1 overflow-y-auto items-center h-[calc(100vh-80px)] sm:grid-cols-2">
        <div class="flex flex-col gap-y-4  sm:gap-y-8 bg-secondary h-full justify-center">
            <div class="w-3/4 self-center bg-secondary">
                <span class="text-white text-xl md:text-3xl lg:text-5xl font-bold sm:hidden">
                    Umiesz w paletki?
                </span>

                <span class="text-white text-xl md:text-3xl lg:text-5xl font-bold hidden sm:block">
                    Umiesz <br> w paletki?
                </span>

            </div>
            <div class="w-3/4 self-center text-right   ">
                <span class="text-accent3 text-xl md:text-3xl lg:text-5xl font-bold sm:hidden">
                    Spróbuj w tenis!
                </span>
                <span class="text-accent3 text-xl md:text-3xl lg:text-5xl font-bold hidden sm:block">
                    Spróbuj <br> w tenis!
                </span>
            </div>
            <div class="w-3/4 self-center">
                <span class="text-accent2 text-xl md:text-3xl lg:text-5xl font-bold sm:hidden">
                    Rezerwuj korty już dziś!
                </span>
                <span class="text-accent2 text-xl md:text-3xl lg:text-5xl font-bold hidden sm:block">
                    Rezerwuj korty <br> już dziś!
                </span>
            </div>
        </div>
        <div class="bg-accent3 h-full content-center px-8">
            <div class="flex flex-col justify-center items-center">
                <span class="text-accent1 text-2xl md:text-4xl mb-8 font-bold">Witaj w aplikacji tenisso!</span>
                <div class="flex gap-x-6">
                    <Link
                        :href="route('login')"
                        class="w-fit bg-accent1 text-center text-white text-xl md:text-2xl px-4 py-2 rounded-lg">
                        Zaloguj się
                    </Link>
                    <Link
                        :href="route('register')"
                        class="w-fit bg-secondary text-center text-white text-xl md:text-2xl px-4 py-2 rounded-lg">
                        Utwórz konto
                    </Link>
                </div>

            </div>
        </div>
    </div>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
