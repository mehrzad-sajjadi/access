<template>
    <Head title="Create new Role" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                افزودن نقش
            </h2>
        </template>

        <div
            class="flex flex-col w-5/6 mx-auto my-16 border border-gray-500 rounded-lg"
        >
            <div
                class="flex flex-row items-center w-full min-h-min bg-[#21252908] border-b-2"
            >
                <p class="px-4 m-2 text-xl">ایجاد نقش جدید</p>
            </div>
            <div class="flex flex-col justify-between">
                <div>
                    <div class="mb-5 py-2 px-2 w-full">
                        <label
                            class="block mb-2 text-lg font-medium text-gray-900 dark:text-white"
                        >
                            نام نقش
                        </label>
                        <input
                            v-model="form.name"
                            type="text"
                            class="block w-52 p-4 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-base focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            autofocus
                        />
                        <p v-if="$page.props.errors.name" class="text-red-600">
                            {{ $page.props.errors.name }}
                        </p>
                    </div>
                </div>

                <div class="flex flex-row justify-between mb-4">
                    <button
                        @click="submit"
                        class="h-9 px-4 m-2 text-lg duration-150 rounded focus:shadow-outline bg-white hover:bg-blue-600 text-blue-600 hover:text-white border border-blue-600 hover:border-transparent"
                    >
                        ایجاد نقش
                    </button>
                    <Link
                        :href="route('role.index')"
                        type="submit"
                        as="button"
                        class="h-9 px-4 m-2 text-lg duration-150 rounded focus:shadow-outline bg-[#ffc107] hover:bg-[#ffe607] text-black border border-[#ffc107] hover:border-transparent"
                    >
                        انصراف
                    </Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script setup>
import { Head, useForm, Link, usePage } from "@inertiajs/vue3";
import Dashboard from "@/Pages/Dashboard.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useKeypress } from "vue3-keypress";

useKeypress({
    keyEvent: "keypress",
    keyBinds: [
        {
            keyCode: "enter",
            modifiers: ["shiftKey"],
            success: submit,
        },
    ],
});
const props = defineProps({
    errors: Object,
});
const form = useForm({
    name: "",
});

function submit() {
    form.post(route("role.store"));
}
</script>

<style></style>
