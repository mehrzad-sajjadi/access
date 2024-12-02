<template>
    <Head title="Add Role to User" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Add Role to User
            </h2>
        </template>

        <div
            class="flex flex-col w-5/6 mx-auto my-16 border border-gray-500 rounded-lg"
        >
            <div
                class="flex flex-row justify-between items-center w-full min-h-min bg-[#21252908] border-b-2"
            >
                <p class="px-4 m-2 text-xl">
                    افزودن نقش به
                    <span class="font-bold">{{ user.name }} </span>
                </p>
            </div>
            <div class="flex flex-col justify-between">
                <div class="flex flex-col m-5">
                    <label
                        class="block mb-2 text-lg font-medium text-gray-900 dark:text-white"
                    >
                        نام نقش
                    </label>

                    <select
                        class="block w-[20%] p-4 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-base focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        v-model="form.role_id"
                    >
                        <option
                            class="mr-5"
                            v-for="(role, index) in roles"
                            :key="index"
                            :value="role.id"
                        >
                            {{ role.name }}
                        </option>
                    </select>
                    <!-- <p v-if="$page.props.errors.device_id" class="text-red-600">
                        {{ $page.props.errors.device_id }}
                    </p> -->
                </div>
                <p
                    class="flex flex-row justify-center text-xl text-center pt-5 text-red-600"
                    v-if="$page.props.errors"
                >
                    <span v-for="(error, index) in errors" :key="index">
                        {{ error }}
                    </span>
                </p>

                <div
                    class="flex flex-row justify-between items-center w-full min-h-min bg-[#21252908] border-b-2 mt-5"
                >
                    <button
                        @click="submit"
                        type="button"
                        as="button"
                        class="h-9 px-4 m-2 text-lg duration-150 rounded focus:shadow-outline bg-white hover:bg-blue-600 text-blue-600 hover:text-white border border-blue-600 hover:border-transparent"
                    >
                        افزودن نقش
                    </button>
                    <Link
                        :href="route('user.index')"
                        type="button"
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

const props = defineProps({
    user: Object,
    roles: Object,
    errors: Object,
});
console.log(props.user);
const form = useForm({
    user_id: props.user.id,
    role_id: "",
});
function submit() {
    form.post(route("roleUser.store"));
}
</script>
