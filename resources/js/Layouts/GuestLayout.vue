<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <div class="flex items-center justify-center p-6 min-h-screen bg-indigo-800">
        <div class="w-full max-w-md">
            <div class="mt-8 bg-white rounded-lg shadow-xl overflow-hidden">
                <div class="px-10 py-12">
                    <slot />
                </div>
            </div>
        </div>
    </div>
</template>
