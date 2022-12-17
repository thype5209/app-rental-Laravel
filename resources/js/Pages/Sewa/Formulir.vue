<script setup>
import AuthenticatedLayoutVue from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/inertia-vue3';
import { defineProps, computed } from 'vue';

const data = defineProps({
    formulir: {
        type: Object,
        default: ()=>({})
    },
    data:{
        type: Object,
        default: ()=>({})
    }

})
console.log(data.formulir)
</script>

<template>
    <AuthenticatedLayoutVue>
        <Head title="Formulir Sewa Mobil"/>

    </AuthenticatedLayoutVue>
</template>
