<script setup>
import AuthenticatedLayoutVue from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { defineProps } from 'vue';
import PrimaryButtonVue from '@/Components/PrimaryButton.vue';
import Pengguna from './Pengguna.vue';
const data = defineProps({
    riwayat: {
        type: Object,
        default: () => ({})
    },
    pengguna: {
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
function back() {
    window.history.back()
}
function statusBayar(value) {
    var msg = null;
    switch (value) {
        case '1':
            msg = 'Lunas';
            break;
        case '2':
            msg = 'Denda';
            break;
        case '3':
            msg = 'Belum Lunas';
            break;
        case '4':
            msg = 'Tunggak';
            break;

        default:
            msg = 'error';
            break;
    }
    return msg;
}
</script>

<template>
    <AuthenticatedLayoutVue>

        <Head title="Riwayat pengguna" />
        <div class="w-full overflow-hidden rounded-lg shadow-lg flex flex-col">
            <div class="w-full py-4 bg-default-dark text-white px-4 rounded-md flex justify-between">
                <PrimaryButtonVue class="bg-default-red" @click="back">Kembali</PrimaryButtonVue>
                <PrimaryButtonVue> Data Pengguna = {{ data.riwayat.nama }}</PrimaryButtonVue>
            </div>
            <div class="sm:px-10">
                <table class="table w-full mb-5">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                            <th class="p-1.5 text-xs whitespace-nowrap border text-center">Foto KTP</th>
                            <th class="p-1.5 text-xs whitespace-nowrap border text-center">Nama.</th>
                            <th class="p-1.5 text-xs whitespace-nowrap border text-center">NIK</th>
                            <th class="p-1.5 text-xs whitespace-nowrap border text-center">Alamat</th>
                            <th class="p-1.5 text-xs whitespace-nowrap border text-center">No HP</th>
                            <th class="p-1.5 text-xs whitespace-nowrap border text-center">No HP Kerabat</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td
                                class="  md:px-2 md:py-1 p-1.5 text-center text-xs md:text-[0.80rem] border whitespace-nowrap">
                                <img :src="`/storage/FotoKTP/${data.pengguna.foto_ktp}`" alt="" class="w-52">
                            </td>
                            <td
                                class="  md:px-2 md:py-1 p-1.5 text-center text-xs md:text-[0.80rem] border whitespace-nowrap">
                                {{
                                    data.pengguna.nama
                                }}</td>
                            <td
                                class="  md:px-2 md:py-1 p-1.5 text-center text-xs md:text-[0.80rem] border whitespace-nowrap">
                                {{
                                    data.pengguna.nik
                                }}</td>
                            <td
                                class="  md:px-2 md:py-1 p-1.5 text-center text-xs md:text-[0.80rem] border">
                                {{
                                    data.pengguna.alamat
                                }}</td>
                            <td
                                class="  md:px-2 md:py-1 p-1.5 text-center text-xs md:text-[0.80rem] border whitespace-nowrap">
                                {{
                                    data.pengguna.no_hp
                                }}</td>
                            <td
                                class="  md:px-2 md:py-1 p-1.5 text-center text-xs md:text-[0.80rem] border whitespace-nowrap">
                                {{
                                    data.pengguna.no_hp_lain
                                }}</td>

                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="w-full overflow-x-auto">
                <h1 class="text-center font-semibold">Riwayat Penyewa</h1>
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                            <th class="p-1.5 text-xs whitespace-nowrap border text-center">No.</th>
                            <th class="p-1.5 text-xs whitespace-nowrap border text-center">Kode</th>
                            <th class="p-1.5 text-xs whitespace-nowrap border text-center">No. Polisi</th>
                            <th class="p-1.5 text-xs whitespace-nowrap border text-center">Tanggal Sewa</th>
                            <th class="p-1.5 text-xs whitespace-nowrap border text-center">Tanggal Kembali</th>
                            <!-- <th class="p-1 text-[0.67rem] whitespace-pre border">Penanggung Jawab</th> -->
                            <th class="p-1 text-[0.67rem] whitespace-pre border">Denda</th>
                            <th class="p-1.5 text-xs whitespace-nowrap border text-center">Status sewa</th>
                            <th class="p-1.5 text-xs whitespace-nowrap border text-center">Status Pembayaran</th>
                            <th class="p-1.5 text-xs whitespace-nowrap border text-center">Sisa Pembayaran</th>
                            <th class="p-1.5 text-xs whitespace-nowrap border text-center">Total</th>
                            <th class="p-1.5 text-xs whitespace-nowrap border text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <tr v-for="(sewa, index) in data.riwayat.sewa" :key="sewa" :index="index"
                            class="text-gray-700 dark:text-gray-400">
                            <td
                                class="md:px-2 md:py-1 p-1.5 text-center text-xs md:text-[0.80rem] border whitespace-nowrap">
                                {{ index
                                + 1
                                }}</td>
                            <td
                                class="md:px-2 md:py-1 p-1.5 text-center text-xs md:text-[0.80rem] border whitespace-nowrap">
                                {{
                                    sewa.kode
                                }}</td>
                            <td
                                class="md:px-2 md:py-1 p-1.5 text-center text-xs md:text-[0.80rem] border whitespace-nowrap">
                                {{
                                    sewa.nopol
                                }}</td>
                            <td
                                class="md:px-2 md:py-1 p-1.5 text-center text-xs md:text-[0.80rem] border whitespace-nowrap">
                                {{
                                    sewa.waktusewa.tgl_sewa
                                }}</td>
                            <td
                                class="md:px-2 md:py-1 p-1.5 text-center text-xs md:text-[0.80rem] border whitespace-nowrap">
                                {{ sewa.waktusewa.tgl_kembali }}
                                <br />
                            </td>
                            <td
                                class="md:px-2 md:py-1 p-1.5 text-center text-xs md:text-[0.80rem] border whitespace-nowrap">
                                Rp. {{
                                    Number(sewa.denda).toLocaleString()
                                }}</td>

                            <td class=" whitespace-nowrap md:px-4 md:py-3 px-2 py-2 text-xs border">
                                <span
                                    class="px-2 py-1 font-semibold cursor-pointer leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">{{
                                        sewa.status
                                    }}</span>
                            </td>
                            <td class=" whitespace-nowrap md:px-4 md:py-3 px-2 py-2 text-xs border">
                                <span
                                    class="px-2 py-1 font-semibold cursor-pointer leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">{{
                                        statusBayar(sewa.status_bayar)
                                    }}</span>
                            </td>
                            <td class=" whitespace-nowrap md:px-4 md:py-3 px-2 py-2 text-xs border">
                                Rp. {{ reduceArray(sewa.sisa) }}
                            </td>
                            <td class=" whitespace-nowrap md:px-4 md:py-3 px-2 py-2 text-xs border">
                                Rp. {{ reduceArray(sewa.total) }}
                            </td>
                            <td class=" whitespace-nowrap md:px-4 md:py-3 px-2 py-2 text-sm flex">
                                <Link :href="route('Sewa.show', { id: sewa.id })">
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
        </div>
    </AuthenticatedLayoutVue>
</template>
