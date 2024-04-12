<script setup>
import {ref,watch} from "vue";
import Pagination from "@/Components/Common/Table/Pagination.vue";

const props = defineProps({
    columns: Array,
    data: Object,
})


</script>
<template>
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <th scope="col" class="px-6 py-3 rounded-tl-lg"> #</th>
                <template v-for="column in columns">
                    <th scope="col" class="px-6 py-3 rounded-tl-lg">{{ column.label }}</th>
                </template>
            </thead>
            <tbody>
                <template v-if="props.data.data && props.data.data?.length < 1">
                    <tr>
                    <td colspan="99" class="text-center py-6 px-3 text-sm text-gray-600">
                        <div class="flex justify-center items-center">
                        <div class="">
                            <img class="w-[10rem] opacity-40" src="/img/empty-box.png">
                            <p class="text-gray-300 text-lg mt-3">Data not found</p>
                        </div>
                        </div>
                    </td>
                    </tr>
                </template >
                <template v-else v-for="(item, index) in props.data.data" :key="index">
                    <tr  class="hover:shadow-sm hover:bg-slate-50">
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap light:text-white">
                            {{ index+1}}
                        </td>
                        <template v-for="column in columns">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap light:text-white">
                                <slot :name="`column_${column.field}`" :props="item">
                                    {{ item[column.field] }}
                                </slot>
                            </td>
                        </template>
                    </tr>
                </template>
            </tbody>
        </table>
        <div class="mt-8">
            <Pagination
                v-if="props.data && data.data?.length"
                :total="props.data.total ?? 0"
                :from="props.data.from ?? 0"
                :to="props.data.to ?? 0"
                :links="props.data.links ?? []"
                :current_page="props.data.current_page ?? null"
                :next_page_url="props.data.next_page_url ?? '#'"
                :prev_page_url="props.data.prev_page_url ?? '#'"
            />
        </div>
</template>


