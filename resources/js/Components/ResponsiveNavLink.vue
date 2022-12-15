<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps(['href', 'active']);

const classes = computed(() =>
    props.active
        ? 'relative flex flex-row items-center h-11 focus:outline-none hover:bg-default-dark dark:hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 dark:hover:border-gray-800 pr-6 border-blue-500'
        : 'relative flex flex-row items-center h-11 focus:outline-none hover:bg-default-dark dark:hover:bg-gray-600 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-500 dark:hover:border-gray-800 pr-6'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
