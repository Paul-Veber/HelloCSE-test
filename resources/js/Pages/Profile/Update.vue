<script setup lang="ts">
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const props = defineProps<{
    id: number;
}>();

console.log(props.id);

interface UpdateForm {
    id: number;
    first_name: string | undefined;
    last_name: string | undefined;
    image: File | undefined;
    status: string | undefined;
}

const form = useForm<UpdateForm>({
    id: props.id,
    first_name: undefined,
    last_name: undefined,
    image: undefined,
    status: undefined,
});

const submit = () => {
    form.patch(route("api.profile.update"));
};

const selectStatus = (event: Event) => {
    const target = event.target as HTMLSelectElement;
    form.status = target.value === "undefined" ? undefined : target.value;
};
</script>

<template>
    <GuestLayout>
        <Head title="Update Profile" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="first_name" value="First Name" />

                <TextInput
                    id="first_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.first_name"
                    autofocus
                    autocomplete="first_name"
                />

                <InputError class="mt-2" :message="form.errors.first_name" />
            </div>

            <div class="mt-4">
                <InputLabel for="last_name" value="Last Name" />

                <TextInput
                    id="last_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.last_name"
                    autocomplete="last_name"
                />

                <InputError class="mt-2" :message="form.errors.last_name" />
            </div>

            <div class="mt-4">
                <InputLabel for="status" value="Status" />

                <select
                    id="status"
                    class="mt-1 block w-full"
                    @change="selectStatus($event)"
                >
                    <option selected value="undefined">Select Status</option>
                    <option value="active">Active</option>
                    <option value="waiting">Waiting</option>
                    <option value="inactive">Inactive</option>
                </select>

                <InputError class="mt-2" :message="form.errors.status" />
            </div>

            <div class="mt-4">
                <InputLabel for="image" value="Image" />

                <TextInput
                    id="last_name"
                    type="file"
                    class="mt-1 block w-full"
                    @input="form.image = $event.target.files[0]"
                />

                <InputError class="mt-2" :message="form.errors.image" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Update
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
