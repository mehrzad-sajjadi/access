<template>
    <div class="w-[70%] p-4 bg-gray-100 rounded-lg shadow-md">
        <table
            class="min-w-full hover:bg-[#f0f4f8] bg-white border border-gray-300 rounded-lg overflow-hidden"
        >
            <thead class="bg-blue-600 text-white">
                <tr>
                    <!-- هدر جدول -->
                    <th
                        class="text-center py-3 px-6 text-base font-semibold uppercase tracking-wider"
                        v-for="(header, index) in headers"
                        :key="index"
                    >
                        {{ header }}
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white text-center divide-y divide-gray-200">
                <!-- ساختن سطر برای هر بعد از ابجکت -->

                <tr
                    v-for="(array, index) in arrays"
                    :key="index"
                    class="hover:bg-gray-100 transition-all duration-300 ease-in-out h-8 px-4 m-2"
                >
                    <td
                        v-for="(item, index) in array"
                        :key="index"
                        class="py-3 px-6"
                    >
                        <span v-if="item.type == 'text'" :class="item.class">
                            {{ item.data }}
                        </span>
                        <span
                            v-else-if="item.type == 'button'"
                            class="flex justify-center"
                        >
                            <span
                                v-for="(btn, index) in item.items"
                                :key="index"
                            >
                                <Link
                                    v-if="btn.type == 'delete'"
                                    class="h-8 px-4 m-2 flex items-center text-sm text-white duration-150 rounded-lg bg-red-600 border-red-600 border hover:border-black"
                                    type="button"
                                    :method="btn.method"
                                    as="button"
                                    :href="btn.data"
                                >
                                    {{ btn.value }}
                                    <TrashIcon class="size-4"></TrashIcon>
                                </Link>
                                <Link
                                    v-if="btn.type == 'edit'"
                                    class="h-8 px-4 m-2 flex items-center text-sm transition-colors duration-150 rounded-lg focus:shadow-outline bg-white hover:bg-black text-black hover:text-white border border-black hover:border-transparent"
                                    type="button"
                                    :method="btn.method"
                                    as="button"
                                    :href="btn.data"
                                >
                                    {{ btn.value }}
                                    <PencilSquareIcon
                                        class="size-4"
                                    ></PencilSquareIcon>
                                </Link>

                                <Link
                                    v-if="btn.type == 'show'"
                                    class="h-8 px-4 flex items-center m-2 text-sm text-indigo-100 transition-colors duration-150 bg-blue-500 hover:bg-blue-950 rounded-lg focus:shadow-outline"
                                    type="button"
                                    :method="btn.method"
                                    as="button"
                                    :href="btn.data"
                                >
                                    {{ btn.value }}
                                    <EyeIcon class="size-4"></EyeIcon>
                                </Link>

                                <button
                                    v-if="btn.type == 'axios'"
                                    class="h-8 px-4 flex items-center m-2 text-sm text-indigo-100 transition-colors duration-150 bg-blue-500 hover:bg-blue-950 rounded-lg focus:shadow-outline"
                                    type="button"
                                    :method="btn.method"
                                    as="button"
                                    @click="runModal(btn.data, array.id.data)"
                                >
                                    {{ btn.value }}
                                    <EyeIcon class="size-4"></EyeIcon>
                                </button>

                                <Link
                                    v-if="btn.type == 'add'"
                                    class="h-8 px-4 flex items-center m-2 text-sm transition-colors duration-150 bg-[#9dff00] hover:bg-[#fbff00] rounded-lg focus:shadow-outline border hover:border-black"
                                    type="button"
                                    :method="btn.method"
                                    as="button"
                                    :href="btn.data"
                                >
                                    {{ btn.value }}
                                    <PlusIcon class="size-4"></PlusIcon>
                                </Link>
                            </span>
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <teleport to="body">
        <Modal
            v-if="showModal == true"
            @closeModal="
                () => {
                    showModal = false;
                }
            "
        >
            <template #header_title> {{ axiosTitle }} </template>
            <template #content>
                <Table
                    :headers="axiosTableHeader"
                    :arrays="axiosContent"
                ></Table>
            </template>
        </Modal>
    </teleport>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { reactive, useSlots, ref } from "vue";
import Modal from "@/Pages/Category/Modal2.vue";
const props = defineProps({
    arrays: Object,
    headers: Object,
    id: String,
});

const showModal = ref(false);
const axiosContent = ref(null);
const axiosTableHeader = ref(null);
const axiosTitle = ref(null);
const emit = defineEmits(["id", "response"]);
function sendDate(id) {
    emit("id", id);
}

const data = ref(null);
function runModal(p1, p2) {
    showModal.value = true;
    let routeName = p1;
    axios
        .post(routeName, {
            id: p2,
        })
        .then((response) => {
            axiosContent.value = response.data["content"];
            axiosTableHeader.value = response.data["tableHeader"];
            axiosTitle.value = response.data["title"];
        });
}

const slots = useSlots();
function hasSlots(name) {
    return slots[name] && !isEmptySlot(slots[name]()).length;
}
function isEmptySlot(items) {
    if (!items.length) return true;
    return !items.some(hasSlotContent);
}
function hasSlotContent(item) {
    const type = item.type.toString();
    if (type === "Symbol(Comment)") return false;
    if (type === "Symbol(Text)" && !item.children.trim()) return false;
    return true;
}

import {
    TrashIcon,
    EyeIcon,
    PencilSquareIcon,
    PlusCircleIcon,
    PlusIcon,
} from "@heroicons/vue/24/solid";
</script>
