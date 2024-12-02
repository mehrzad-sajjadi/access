<template>
    <Head title="Room" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex w-[100%] flex-row justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    لیست دسترسی های {{ role.name }}
                </h2>
                <Link
                    :href="route('license.create', role.id)"
                    as="button"
                    type="button"
                    class="h-8 px-4 flex items-center m-2 text-sm transition-colors duration-150 bg-[#6c757d] hover:bg-[#757b80] rounded-lg text-white border border-[#6c757d] hover:border-transparent"
                >
                    افزودن دسترسی
                    <KeyIcon class="size-4"></KeyIcon>
                </Link>
            </div>
        </template>
        <div class="flex justify-center py-4">
            <Table :headers="header" :arrays="licenses"></Table>
        </div>
        <p
            class="flex flex-row justify-center text-xl text-center"
            v-if="$page.props.crud.success"
        >
            {{ $page.props.crud.success }}
        </p>
        <p
            class="flex flex-row justify-center text-xl text-center pt-5 text-red-600"
            v-if="$page.props.errors"
        >
            <span v-for="(error, index) in errors" :key="index">
                {{ error }}
            </span>
        </p>
    </AuthenticatedLayout>
</template>

<script setup>
import { Link, router, usePage, Head, useForm } from "@inertiajs/vue3";
import Table from "@/Components/Table.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {
    TrashIcon,
    EyeIcon,
    PencilSquareIcon,
    PlusCircleIcon,
    ClipboardDocumentListIcon,
    HandThumbDownIcon,
    CheckBadgeIcon,
    StarIcon,
    KeyIcon,
} from "@heroicons/vue/24/solid";
const header = ["نوع دسترسی", "بخش", "عملیات"];
const props = defineProps({
    role: Object,
    licenses: Object,
    errors: Object,
});
</script>
