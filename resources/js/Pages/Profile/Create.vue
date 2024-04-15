<script setup lang="ts">
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const form = useForm({
    first_name: "",
    last_name: "",
    //image: '',
    status: "",
});

const submit = () => {
    form.post(route("api.profile.store"));
};
</script>

<template>
    <GuestLayout>
        <Head title="Create Profile" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="first_name" value="First Name" />

                <TextInput
                    id="first_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.first_name"
                    required
                    autofocus
                    autocomplete="first_name"
                />

                <InputError class="mt-2" :message="form.errors.firstname" />
            </div>

            <div class="mt-4">
                <InputLabel for="last_name" value="Last Name" />

                <TextInput
                    id="last_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.last_name"
                    required
                    autocomplete="last_name"
                />

                <InputError class="mt-2" :message="form.errors.lastname" />
            </div>

            <div class="mt-4">
                <InputLabel for="status" value="Status" />

                <select
                    id="status"
                    class="mt-1 block w-full"
                    v-model="form.status"
                    required
                >
                    <option value="active">Active</option>
                    <option value="waiting">Waiting</option>
                    <option value="inactive">Inactive</option>
                </select>

                <InputError class="mt-2" :message="form.errors.status" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Create
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
