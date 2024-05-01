<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import Aside from "@/Layouts/Aside.vue";
import MainContent from "@/Components/MainContent.vue";
import { Head } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout></AuthenticatedLayout>
    <Aside></Aside>

    <MainContent>
        <div class="flex gap-y-8 flex-col max-w-screen-xl">
            <div class="p-4 sm:p-8 bg-primary shadow sm:rounded-lg">
                <UpdateProfileInformationForm
                    :must-verify-email="mustVerifyEmail"
                    :status="status"
                    class="max-w-xl"
                />
            </div>

            <div class="p-4 sm:p-8 bg-primary shadow sm:rounded-lg">
                <UpdatePasswordForm class="max-w-xl" />
            </div>

            <div class="p-4 sm:p-8 bg-primary shadow sm:rounded-lg">
                <DeleteUserForm class="max-w-xl" />
            </div>
        </div>
    </MainContent>

</template>
