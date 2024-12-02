<template>
    <Head title="Room" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex w-[100%] flex-row justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    لیست کاربران
                </h2>

                <Link
                    :href="route('user.create')"
                    as="button"
                    type="button"
                    class="h-8 px-4 flex items-center m-2 text-sm transition-colors duration-150 bg-[#6c757d] hover:bg-[#757b80] rounded-lg text-white border border-[#6c757d] hover:border-transparent"
                >
                    افزودن کاربر
                    <UserPlusIcon class="size-5"></UserPlusIcon>
                </Link>
            </div>
        </template>
        <div class="flex justify-center py-4">
            <Table
                :headers="header"
                :arrays="users"
                @response="
                    (p) => {
                        popupData = p;
                        popup = true;
                    }
                "
            >
                <Teleport to="body">
                    <div v-if="popup == true">
                        <Show
                            :roles="popupData"
                            :user="{ id: 1, name: 'mehrzad' }"
                            @close="popup = false"
                        ></Show>
                    </div>
                </Teleport>
            </Table>
        </div>
        <!-- <div v-if="popup == true">
            <Show
                :roles="popupData"
                :user="{ id: 1, name: 'mehrzad' }"
                @close="cahnge"
            ></Show>
        </div> -->
    </AuthenticatedLayout>
</template>

<script setup>
import { Link, router, usePage, Head, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import Table from "@/Components/Table.vue";
import Show from "@/Pages/User/show.vue";
import { onClickOutside } from "@vueuse/core";
import DangerButton from "@/Components/DangerButton.vue";

const targetRef = ref(null);
const popup = ref(false);
const popupData = ref(null);

const props = defineProps({
    users: Object,
    header: Object,
});

function cahnge() {
    popup.value = !popup.value;
    console.log("popup variable == ", popup.value);
}

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
} from "@heroicons/vue/24/solid";
</script>
