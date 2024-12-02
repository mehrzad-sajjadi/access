<template>
    <div
        class="fixed top-0 right-0 left-0 bottom-0 bg-[#0d09089c] p-10 content-center"
    >
        <div ref="checkOut" class="rounded-md m-auto bg-white width-[800px]">
            <XMarkIcon
                @click="closeShow"
                as="button"
                type="button"
                class="size-5 cursor-pointer"
            />

            <div class="flex w-[100%] flex-row justify-between items-center">
                <h2
                    class="font-semibold text-xl text-gray-800 leading-tight m-2"
                >
                    لیست پست های {{ category.name }}
                </h2>
                <!-- class="h-8 px-4 flex items-center m-2 text-sm transition-colors duration-150 bg-[#6c757d] hover:bg-[#757b80] rounded-lg text-white border border-[#6c757d] hover:border-transparent" -->

                <div class="flex flex-row">
                    <button
                        @click="remove(category.id)"
                        as="button"
                        type="button"
                        class="h-8 px-4 m-2 flex items-center text-sm text-white duration-150 rounded-lg bg-red-600 border-red-600 border hover:border-black"
                    >
                        حذف دسته بندی
                        <TrashIcon class="size-5"></TrashIcon>
                    </button>

                    <!-- <Link
                    :href="route('category.index')"
                    as="button"
                    type="button"
                    class="h-8 px-4 flex items-center m-2 text-sm transition-colors duration-150 bg-[#6c757d] hover:bg-[#757b80] rounded-lg text-white border border-[#6c757d] hover:border-transparent"
                >
                    بازگشت
                </Link> -->
                </div>
            </div>
            <div class="flex justify-center py-4">
                <Table :headers="header" :arrays="posts"></Table>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, router, usePage, Head, useForm } from "@inertiajs/vue3";
import Table from "@/Components/Table.vue";
import {
    TrashIcon,
    EyeIcon,
    PencilSquareIcon,
    PlusCircleIcon,
    ClipboardDocumentListIcon,
    HandThumbDownIcon,
    CheckBadgeIcon,
    UserPlusIcon,
    XMarkIcon,
} from "@heroicons/vue/24/solid";

const props = defineProps({
    posts: Object,
    category: Object,
    header: Object,
});
function remove(p) {
    if (confirm("آیا از حذف دسته بندی مطمئنید ؟")) {
        router.delete(route("category.delete", p));
    }
}
</script>
