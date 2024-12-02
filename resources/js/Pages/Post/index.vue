<template>
    <Head title="Room" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex w-[100%] flex-row justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    لیست پست ها
                </h2>
                <!-- class="h-8 px-4 flex items-center m-2 text-sm transition-colors duration-150 bg-[#6c757d] hover:bg-[#757b80] rounded-lg text-white border border-[#6c757d] hover:border-transparent" -->

                <Link
                    :href="route('post.create')"
                    as="button"
                    type="button"
                    class="h-8 px-4 flex items-center m-2 text-sm transition-colors duration-150 bg-[#6c757d] hover:bg-[#757b80] rounded-lg text-white border border-[#6c757d] hover:border-transparent"
                >
                    افزودن پست
                    <DocumentPlusIcon class="size-5"></DocumentPlusIcon>
                </Link>
            </div>
        </template>
        <div class="flex justify-center py-4">
            <Table :headers="header" :arrays="posts"></Table>
        </div>
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
    UserPlusIcon,
    DocumentPlusIcon,
} from "@heroicons/vue/24/solid";
const header = ["id", "نام پست", "عملیات"];
const props = defineProps({
    posts: Object,
    errors: Object,
});
console.log(props.posts);
function remove(p) {
    if (confirm("آیا از حذف کاربر مطمئنید ؟")) {
        router.delete(route("user.delete", p));
    }
}
</script>
