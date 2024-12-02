<template>
    <Head title="Add Users" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex w-[100%] flex-row justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    افزودن کاربران
                </h2>
            </div>
        </template>

        <GuestLayout>
            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="name" value="Name" />

                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                    />

                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="mt-4">
                    <InputLabel for="email" value="Email" />

                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autocomplete="username"
                    />

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password" value="Password" />

                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        required
                        autocomplete="new-password"
                    />

                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="mt-4">
                    <InputLabel
                        for="password_confirmation"
                        value="Confirm Password"
                    />

                    <TextInput
                        id="password_confirmation"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.password_confirmation"
                    />
                </div>

                <div class="mt-4 flex items-center justify-between">
                    <button
                        @click="submit"
                        type="button"
                        as="button"
                        class="h-9 px-4 m-2 text-lg duration-150 rounded focus:shadow-outline bg-[#0cebff] hover:bg-[#22a4d8] text-black border border-[#0cebff] hover:border-transparent"
                    >
                        افزودن
                    </button>
                    <Link
                        :href="route('user.index')"
                        type="submit"
                        as="button"
                        class="h-9 px-4 m-2 text-lg duration-150 rounded focus:shadow-outline bg-[#ffc107] hover:bg-[#ffe607] text-black border border-[#ffc107] hover:border-transparent"
                    >
                        انصراف
                    </Link>
                </div>
            </form>
        </GuestLayout>
    </AuthenticatedLayout>
</template>

<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {
    TrashIcon,
    EyeIcon,
    PencilSquareIcon,
    PlusCircleIcon,
    ClipboardDocumentListIcon,
    HandThumbDownIcon,
    CheckBadgeIcon,
    UserPlusIcon,
    ArrowUturnLeftIcon,
} from "@heroicons/vue/24/solid";

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
});

function submit() {
    form.post(route("user.store"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
}
</script>
