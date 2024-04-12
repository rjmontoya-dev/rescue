<script setup>
import {defineProps} from 'vue'
import {Link, router} from '@inertiajs/vue3';

const props = defineProps({
    links: {
        type: Array,
        default: 0,
    },
    next_page_url: {
        type: String,
        default: null,
    },
    current_page: {
        type: Number,
        default: null,
    },
    prev_page_url: {
        type: String,
        default: null,
    },
    total: {
        type: Number,
        default: null,
    },
    from: {
        type: Number,
        default: null,
    },
    to: {
        type: Number,
        default: null,
    },
    preserveScroll: {
        type: Boolean,
    }
});
const showPageLink = (pageNumber) => {
    const currentPageNumber = parseInt(props.current_page);
    const pageDifference = Math.abs(pageNumber - currentPageNumber);

    return pageDifference <= 2 || pageNumber === 1 || pageNumber === parseInt(props.total);
}
</script>
<template>
    <nav class="block sm:flex items-center text-center justify-between pt-0" aria-label="Table navigation">
        <span class="text-sm text-gray-500">Showing <span class="">{{ `${ from} to ${ to}` }}</span> of <span
            class="">{{  total }}</span><span> entries</span></span>
        <nav >
            <ul class="flex items-center justify-center gap-1  h-8 text-sm">
                <li>
                    <Link
                        :style="{'pointer-events':  prev_page_url == null ? 'none' : 'auto' }"
                        :href=" prev_page_url"
                        class="flex items-center rounded-full justify-center link px-3 h-8 w-8 ml-0 leading-tight text-gray-500 bg-white hover:text-white hover:bg-primary-300 border border-gray-300 "
                        :class="{ 'text-gray-200': !prev_page_url }"
                    >
                    <i class="bi bi-chevron-left"></i>
                    </Link>
                </li>
                <template v-for="link in links" :key="link.label">

                    <li v-if="!isNaN(link.label) && showPageLink(link.label)">

                        <Link
                            :href="link.url"
                            :class="{ 'active text-white !bg-gray-700 hover:!bg-blue-300': link.active }"
                            class="flex items-center rounded-full justify-center px-4 w-8 h-8  text-gray-500 bg-white border border-gray-300 hover:bg-primary-300 hover:text-white"
                        >
                            {{ link.label }}
                        </Link>
                    </li>
                </template>
                <li>
                    <Link
                        :style="{'pointer-events': next_page_url == null ? 'none' : 'auto' }"
                        :href="next_page_url"
                        class="flex items-center rounded-full justify-center link px-3 h-8 w-8 ml-0 leading-tight text-gray-500 bg-white hover:text-white hover:bg-primary-300 border border-gray-300 "
                        :class="{ 'text-gray-200': !next_page_url }"
                    >
                        <i class="bi bi-chevron-right"></i>

                    </Link>
                </li>
            </ul>
        </nav>
    </nav>
</template>
