<script setup>
import { Head } from '@inertiajs/inertia-vue3';
</script>

<template>
    <AuthenticatedLayoutVue>
        <Head title="Detail Mobil"/>
    </AuthenticatedLayoutVue>
</template>
<script>
import AuthenticatedLayoutVue from '../../Layouts/AuthenticatedLayout.vue'

export default {
    name: 'ShowVue',
    components:{
        AuthenticatedLayoutVue
    }
}
</script>
