<template>
    <AuthenticatedLayoutVue>

        <Head title="Show Sewa" />
        <div class="overflow-hidden px-3 md:px-10 flex flex-1 bg-gray-50">

            <table class="table w-full border-collapse text-left ">
                <tr class="border-b border-gray-200 dark:border-gray-700">
                    <th scope="row" colspan="2"
                        class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                        <PrimaryButtonVue @click="back" class="bg-default-red hover:bg-red-500">Kembali</PrimaryButtonVue>

                    </th>
                </tr>
                <tr>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-sm sm:text-base capitalize whitespace-pre-wrap">
                        Kode Sewa</td>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-sm sm:text-base capitalize whitespace-pre-wrap font-semibold">
                        {{ sewa.kode }}</td>
                </tr>
                <tr>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-sm sm:text-base capitalize whitespace-pre-wrap">
                        Harga Sewa</td>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-sm sm:text-base capitalize whitespace-pre-wrap font-semibold">
                        Rp. {{ sewa.harga }}</td>
                </tr>
                <tr>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-sm sm:text-base capitalize whitespace-pre-wrap">
                        Unit Mobil</td>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-sm sm:text-base capitalize whitespace-pre-wrap font-semibold">
                        {{ sewa.unit }}/{{ sewa.nopol }}/{{
                        sewa.tahun
                        }} </td>
                </tr>
                <tr>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-sm sm:text-base capitalize whitespace-pre-wrap">
                        Penyewa</td>
                    <td class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-sm sm:text-base capitalize whitespace-pre-wrap font-semibold"
                        v-if="sewa.pengguna != null">{{ sewa.pengguna.nama }}/{{ sewa.nik }}</td>
                    <td class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-sm sm:text-base capitalize whitespace-pre-wrap font-semibold"
                        v-else>{{ sewa.nik }}</td>
                </tr>
                <tr v-if="sewa.pengguna != null">
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-sm sm:text-base capitalize whitespace-pre-wrap">
                        Alamat Penyewa</td>
                    <td class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-sm sm:text-base capitalize whitespace-pre-wrap font-semibold"
                        v-if="sewa.pengguna != null">{{ sewa.pengguna.alamat }}</td>
                </tr>
                <tr v-if="sewa.pengguna != null">
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-sm sm:text-base capitalize whitespace-pre-wrap">
                        Nomor HP Penyewa</td>
                    <td class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-sm sm:text-base capitalize whitespace-pre-wrap font-semibold"
                        v-if="sewa.pengguna != null">{{ sewa.pengguna.no_hp }}/{{ sewa.pengguna.no_hp_lain }} </td>
                </tr>
                <tr>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-sm sm:text-base capitalize whitespace-pre-wrap">
                        Tujuan</td>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-sm sm:text-base capitalize whitespace-pre-wrap font-semibold">
                        {{ sewa.tujuan }}</td>
                </tr>
                <tr>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-sm sm:text-base capitalize whitespace-pre-wrap">
                        Jaminan</td>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-sm sm:text-base capitalize whitespace-pre-wrap font-semibold">
                        {{ sewa.jaminan }}</td>
                </tr>
                <tr>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-sm sm:text-base capitalize whitespace-pre-wrap">
                        Tanggal sewa</td>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-sm sm:text-base capitalize whitespace-pre-wrap font-semibold">
                        {{ sewa.waktusewa.tgl_sewa }}</td>
                </tr>
                <tr>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-sm sm:text-base capitalize whitespace-pre-wrap">
                        Tanggal Kembali</td>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-sm sm:text-base capitalize whitespace-pre-wrap font-semibold">
                        {{ sewa.waktusewa.tgl_kembali }}</td>
                </tr>
                <tr>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-sm sm:text-base capitalize whitespace-pre-wrap">
                        Lama Sewa</td>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-sm sm:text-base capitalize whitespace-pre-wrap font-semibold">
                        {{ sewa.waktusewa.lama_sewa }} Hari</td>
                </tr>

            </table>
        </div>
    </AuthenticatedLayoutVue>
</template>

<script>
import AuthenticatedLayoutVue from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import PrimaryButtonVue from "@/Components/PrimaryButton.vue"
export default {
    name: 'ShowSewaVue',
    components: {
        AuthenticatedLayoutVue,
        Head,
        Link,
        PrimaryButtonVue
    },
    props: {
        sewa: {
            type: Object,
            default: () => ({})
        },
    },
    methods:{
        back() {
      window.history.back();
    },

    }

}
</script>
