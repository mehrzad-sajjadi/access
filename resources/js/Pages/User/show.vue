<template>
    <Head title="Room" />
    <div
        class="fixed top-0 right-0 left-0 bottom-0 bg-[#0d09089c] p-10 content-center"
    >
        <div ref="checkOut" class="rounded-md m-auto bg-white">
            <XMarkIcon
                @click="closeShow"
                as="button"
                type="button"
                class="size-5 cursor-pointer"
            />
            <div class="p-8 min-w-min min-h-min">
                <div
                    class="flex w-[100%] flex-row justify-between items-center"
                >
                    <h2
                        class="font-semibold text-xl text-gray-800 leading-tight"
                    >
                        لیست نقش های {{ user.name }}
                    </h2>

                    <div class="flex flex-row">
                        <Link
                            :href="route('roleUser.create', user.id)"
                            as="button"
                            type="button"
                            class="h-8 px-4 flex items-center m-2 text-sm transition-colors duration-150 bg-[#6c757d] hover:bg-[#757b80] rounded-lg text-white border border-[#6c757d] hover:border-transparent"
                        >
                            افزودن نقش
                        </Link>
                        <button
                            @click="remove(user.id)"
                            as="button"
                            type="button"
                            class="h-8 px-4 m-2 flex items-center text-sm text-white duration-150 rounded-lg bg-red-600 border-red-600 border hover:border-black"
                        >
                            حذف کاربر
                            <UserMinusIcon class="size-5"></UserMinusIcon>
                        </button>
                    </div>
                </div>
                <div class="flex justify-center py-4">
                    <Table :headers="header" :arrays="roles"></Table>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, router, usePage, Head, useForm } from "@inertiajs/vue3";
import Table from "@/Components/Table.vue";
import { ref } from "vue";
import { onClickOutside } from "@vueuse/core";

const header = ["id", "نام نقش", "عملیات"];

const props = defineProps({
    roles: Object,
    user: Object,
});
const checkOut = ref(null);

function closeShow() {
    emit("close");
}

const emit = defineEmits("close");
onClickOutside(checkOut, () => {
    emit("close");
});

function remove(p) {
    if (confirm("آیا از حذف کاربر مطمئنید ؟")) {
        router.delete(route("user.delete", p));
    }
}

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
    XMarkIcon,
    UserMinusIcon,
} from "@heroicons/vue/24/solid";
</script>
