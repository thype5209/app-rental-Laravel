<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import { defineProps } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';
import PrimaryButtonVue from '@/Components/PrimaryButton.vue';

const fotoPath = '/storage/';
const props = defineProps({
    mobil: {
        type: Object,
        default: () => ({})
    }
})
function Status(n) {
    var msg = '';
    switch (n) {
        case 1:
            msg = 'Disewa'
            break;
        case 2:
            msg = 'Siap'
            break;
        case 3:
            msg = 'perbaikan'
            break;

        default:
            msg = 'semua'
            break;
    }
    return msg;
}
</script>

<template>
    <AuthenticatedLayoutVue>

        <Head title="Detail Mobil" />

        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <tr class="border-b border-gray-200 dark:border-gray-700">
                    <th scope="row"  colspan="2"
                        class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                        <Link :href="route('Mobil.index')">
                            <PrimaryButtonVue class="bg-default-red hover:bg-red-500">Kembali</PrimaryButtonVue>
                        </Link>
                    </th>
                </tr>
                <tr class="border-b border-gray-200 dark:border-gray-700">
                    <th scope="row"
                        class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                        Status Mobil
                    </th>
                    <td class="py-4 px-6 capitalize">
                        {{ Status(props.mobil.status) }}
                    </td>
                </tr>
                <tr class="border-b border-gray-200 dark:border-gray-700">
                    <th scope="row"
                        class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                        Unit Mobil
                    </th>
                    <td class="py-4 px-6">
                        {{ props.mobil.unit }}
                    </td>
                </tr>
                <tr class="border-b border-gray-200 dark:border-gray-700">
                    <th scope="row"
                        class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                        Spesifikasi Mobil
                    </th>
                    <td class="py-4 px-6">
                        {{ props.mobil.spesifikasi }}
                    </td>
                </tr>
                <tr class="border-b border-gray-200 dark:border-gray-700">
                    <th scope="row"
                        class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                        Nomor Polisi
                    </th>
                    <td class="py-4 px-6">
                        {{ props.mobil.nopol }}
                    </td>
                </tr>
                <tr class="border-b border-gray-200 dark:border-gray-700">
                    <th scope="row"
                        class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                        Tahun
                    </th>
                    <td class="py-4 px-6">
                        {{ props.mobil.tahun }}
                    </td>
                </tr>
                <tr class="border-b border-gray-200 dark:border-gray-700">
                    <th scope="row"
                        class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                        Harga
                    </th>
                    <td class="py-4 px-6">
                        Rp. {{ Number(props.mobil.harga).toLocaleString(2) }}
                    </td>
                </tr>
                <tr class="border-b border-gray-200 dark:border-gray-700">
                    <th scope="row"
                        class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                        Foto Depan
                    </th>
                    <td class="py-4 px-6">
                        <img :src="fotoPath + props.mobil.foto1" class=" aspect-square w-52" alt="Foto Mobil">
                    </td>
                </tr>
                <tr class="border-b border-gray-200 dark:border-gray-700">
                    <th scope="row"
                        class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                        Foto Belakang
                    </th>
                    <td class="py-4 px-6">
                        <img :src="fotoPath + props.mobil.foto2" class=" aspect-square w-52" alt="Foto Mobil">
                    </td>
                </tr>
                <tr class="border-b border-gray-200 dark:border-gray-700">
                    <th scope="row"
                        class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                        Foto Samping Kanan
                    </th>
                    <td class="py-4 px-6">
                        <img :src="fotoPath + props.mobil.foto3" class=" aspect-square w-52" alt="Foto Mobil">
                    </td>
                </tr>
                <tr class="border-b border-gray-200 dark:border-gray-700">
                    <th scope="row"
                        class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                        Foto Samping Kiri
                    </th>
                    <td class="py-4 px-6">
                        <img :src="fotoPath + props.mobil.foto4" class=" aspect-square w-52" alt="Foto Mobil">
                    </td>
                </tr>
            </table>
        </div>

    </AuthenticatedLayoutVue>
</template>
<script>
import AuthenticatedLayoutVue from '../../Layouts/AuthenticatedLayout.vue'

export default {
    name: 'ShowVue',
    components: {
        AuthenticatedLayoutVue
    }
}
</script>
