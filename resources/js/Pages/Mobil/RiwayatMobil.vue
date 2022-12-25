<script setup>
import AuthenticatedLayoutVue from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { defineProps } from 'vue';
import PaginationVue from '@/Components/Pagination.vue';

const data = defineProps({
    riwayat: {
        type: Object,
        default: () => ({})
    }
})
function reduceArray(array = [], lamasewa = 1, denda = 0) {
    var sisa = array.split(',');
    var harga = sisa.reduce((el, b) => el + b);
    var total = (parseInt(harga) * lamasewa) + parseInt(denda);
    return Number(total).toLocaleString();
}
</script>

<template>
    <AuthenticatedLayoutVue>

        <Head title="Riwayat Mobil" />
        <div class="w-full overflow-hidden rounded-lg shadow-lg flex flex-col">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                            <th class="p-1.5 text-xs whitespace-nowrap border text-center">No.</th>
                            <th class="p-1.5 text-xs whitespace-nowrap border text-center">Kode</th>
                            <th class="p-1.5 text-xs whitespace-nowrap border text-center">NIK</th>
                            <th class="p-1.5 text-xs whitespace-nowrap border text-center">Nama Penyewa</th>
                            <th class="p-1.5 text-xs whitespace-nowrap border text-center">No. Polisi</th>
                            <th class="p-1.5 text-xs whitespace-nowrap border text-center">Tanggal Sewa</th>
                            <th class="p-1.5 text-xs whitespace-nowrap border text-center">Tanggal Kembali</th>
                            <th class="p-1 text-[0.67rem] whitespace-pre border">Penanggung Jawab</th>
                            <th class="p-1 text-[0.67rem] whitespace-pre border">Denda</th>
                            <th class="p-1.5 text-xs whitespace-nowrap border text-center">Status</th>
                            <th class="p-1.5 text-xs whitespace-nowrap border text-center">Total</th>
                            <th class="p-1.5 text-xs whitespace-nowrap border text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <tr v-for="(mobil, index) in data.riwayat.data" :key="mobil" :index="index"
                            class="text-gray-700 dark:text-gray-400">
                            <td
                                class="md:px-2 md:py-1 p-1.5 text-center text-xs md:text-[0.80rem] border whitespace-nowrap">
                                {{ index
                                        + 1
                                }}</td>
                            <td
                                class="md:px-2 md:py-1 p-1.5 text-center text-xs md:text-[0.80rem] border whitespace-nowrap">
                                {{
                                        mobil.kode
                                }}</td>
                            <td
                                class="md:px-2 md:py-1 p-1.5 text-center text-xs md:text-[0.80rem] border whitespace-nowrap">
                                <span v-if="mobil.nik != null">{{ mobil.nik }}</span>
                                <span v-else>---------</span>
                            </td>
                            <td class=" whitespace-nowrap md:px-2 md:py-1 p-1.5 text-center text-xs md:text-[0.80rem] border whitespace-nowrap"
                                v-if="mobil.pengguna != null">{{
                                        mobil.pengguna.nama
                                }}</td>
                            <td class=" whitespace-nowrap md:px-2 md:py-1 p-1.5 text-center text-xs md:text-[0.80rem] border whitespace-nowrap"
                                v-else>
                                Sopir</td>
                            <td
                                class="md:px-2 md:py-1 p-1.5 text-center text-xs md:text-[0.80rem] border whitespace-nowrap">
                                {{
                                        mobil.nopol
                                }}</td>
                            <td
                                class="md:px-2 md:py-1 p-1.5 text-center text-xs md:text-[0.80rem] border whitespace-nowrap">
                                {{
                                        mobil.waktusewa.tgl_sewa
                                }}</td>
                            <td
                                class="md:px-2 md:py-1 p-1.5 text-center text-xs md:text-[0.80rem] border whitespace-nowrap">
                                {{ mobil.waktusewa.tgl_kembali }}
                                <br />
                            </td>
                            <td
                                class="md:px-2 md:py-1 p-1.5 text-center text-xs md:text-[0.80rem] border whitespace-nowrap">
                                {{
                                        mobil.user.name
                                }}</td>
                            <td
                                class="md:px-2 md:py-1 p-1.5 text-center text-xs md:text-[0.80rem] border whitespace-nowrap">
                                Rp. {{
                                        Number(mobil.denda).toLocaleString()
                                }}</td>

                            <td class=" whitespace-nowrap md:px-4 md:py-3 px-2 py-2 text-xs border">
                                <span
                                    class="px-2 py-1 font-semibold cursor-pointer leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">{{
                                            mobil.status
                                    }}</span>
                            </td>
                            <td class=" whitespace-nowrap md:px-4 md:py-3 px-2 py-2 text-xs border">
                                Rp. {{ reduceArray(mobil.total) }}
                            </td>
                            <td class=" whitespace-nowrap md:px-4 md:py-3 px-2 py-2 text-sm flex">
                                <Link :href="route('Sewa.show', { id: mobil.id })">
                                <button class="bg-blue-500 text-white px-2 py-1 rounded-md ml-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                                </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <PaginationVue :links="data.riwayat.links" class="mt-3 text-black"></PaginationVue>
        </div>
    </AuthenticatedLayoutVue>
</template>
