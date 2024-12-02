<template>
    <Head title="Category" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex w-[100%] flex-row justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    لیست دسته بندی ها
                </h2>
                <!-- class="h-8 px-4 flex items-center m-2 text-sm transition-colors duration-150 bg-[#6c757d] hover:bg-[#757b80] rounded-lg text-white border border-[#6c757d] hover:border-transparent" -->

                <Link
                    :href="route('category.create')"
                    as="button"
                    type="button"
                    class="h-8 px-4 flex items-center m-2 text-sm transition-colors duration-150 bg-[#6c757d] hover:bg-[#757b80] rounded-lg text-white border border-[#6c757d] hover:border-transparent"
                >
                    افزودن دسته بندی
                    <FolderPlusIcon class="size-5"></FolderPlusIcon>
                </Link>
            </div>
        </template>
        <div class="flex justify-center py-4">
            <Table
                :headers="header"
                :arrays="categories"
                @response="
                    (receivedData) => {
                        newValue = receivedData;
                        showModal = true;
                    }
                "
            >
            </Table>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Link, router, usePage, Head, useForm } from "@inertiajs/vue3";
import Table from "@/Components/Table.vue";
import Show from "./show.vue";
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    categories: Object,
    header: Object,
});
const showModal = ref(false);
const newValue = ref(null);
import {
    TrashIcon,
    EyeIcon,
    PencilSquareIcon,
    PlusCircleIcon,
    ClipboardDocumentListIcon,
    HandThumbDownIcon,
    CheckBadgeIcon,
    UserPlusIcon,
    FolderPlusIcon,
} from "@heroicons/vue/24/solid";
</script>
