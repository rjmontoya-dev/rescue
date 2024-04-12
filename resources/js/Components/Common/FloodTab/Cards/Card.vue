<script setup>
import { Link } from '@inertiajs/vue3';
 const  props = defineProps({
        title: String,
        img: String,
        body:String,
        url: String,
        alt: String,
    })
</script>
<template>
    <div class="bg-white border-t-4 border-gray-800 rounded-lg p-4  mt-4">
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ title }}</h5>
        <hr class="mb-2">
        <img class="rounded-t-lg w-full" :src="img" :alt="alt" />
        <div  >
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{body}}</p>
            <Link :href="url" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-gray-800 rounded-lg hover:bg-gray-500 focus:ring-4 focus:outline-none focus:ring-gray-300">
                Read more
                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                </svg>
            </Link>
        </div>
    </div>
</template>
