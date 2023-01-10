<template>
    <AuthenticatedLayoutVue>

        <Head title="Show Sewa" />
        <div class="overflow-hidden px-3 md:px-10 flex flex-1 bg-gray-50">

            <table class="table w-full border-collapse text-left ">
                <tr class="border-b border-gray-200 dark:border-gray-700">
                    <th scope="row" colspan="2"
                        class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                        <PrimaryButtonVue @click="back" class="bg-default-red hover:bg-red-500">Kembali
                        </PrimaryButtonVue>

                    </th>
                </tr>
                <tr>
                    <td colspan="2"
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-default-dark text-sm sm:text-base capitalize whitespace-pre-wrap font-semibold">
                        <a :href="`/storage/${sewa.pdf_url}`" class="text-blue-500 after:text-red-500" target="_blank">Link PDF</a></td>
                </tr>
                <tr>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-default-dark text-sm sm:text-base capitalize whitespace-pre-wrap">
                        Kode Sewa</td>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-default-dark text-sm sm:text-base capitalize whitespace-pre-wrap font-semibold">
                        {{ sewa.kode }}</td>
                </tr>
                <tr>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-default-dark text-sm sm:text-base capitalize whitespace-pre-wrap">
                        Harga Sewa</td>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-default-dark text-sm sm:text-base capitalize whitespace-pre-wrap font-semibold">
                        Rp. {{ reduceArray(sewa.harga) }}</td>
                </tr>
                <tr>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-default-dark text-sm sm:text-base capitalize whitespace-pre-wrap">
                        Unit Mobil</td>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-default-dark text-sm sm:text-base capitalize whitespace-pre-wrap font-semibold">
                        {{ sewa.unit }}/{{ sewa.nopol }}/{{
                                sewa.tahun
                        }} </td>
                </tr>
                <tr>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-default-dark text-sm sm:text-base capitalize whitespace-pre-wrap">
                        Penyewa/NIK</td>
                    <td class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-default-dark text-sm sm:text-base capitalize whitespace-pre-wrap font-semibold"
                        v-if="sewa.pengguna != null">{{ sewa.pengguna.nama }}/{{ sewa.nik }}</td>
                    <td class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-default-dark text-sm sm:text-base capitalize whitespace-pre-wrap font-semibold"
                        v-else>{{ sewa.nik }}</td>
                </tr>
                <tr v-if="sewa.pengguna != null">
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-default-dark text-sm sm:text-base capitalize whitespace-pre-wrap">
                        Alamat Penyewa</td>
                    <td class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-default-dark text-sm sm:text-base capitalize whitespace-pre-wrap font-semibold"
                        v-if="sewa.pengguna != null">{{ sewa.pengguna.alamat }}</td>
                </tr>
                <tr v-if="sewa.pengguna != null">
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-default-dark text-sm sm:text-base capitalize whitespace-pre-wrap">
                        Nomor HP Penyewa/Kerabat</td>
                    <td class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-default-dark text-sm sm:text-base capitalize whitespace-pre-wrap font-semibold"
                        v-if="sewa.pengguna != null">{{ sewa.pengguna.no_hp }} / {{ sewa.pengguna.no_hp_lain }} </td>
                </tr>
                <tr>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-default-dark text-sm sm:text-base capitalize whitespace-pre-wrap">
                        Tujuan</td>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-default-dark text-sm sm:text-base capitalize whitespace-pre-wrap font-semibold">
                        {{ sewa.tujuan }}</td>
                </tr>
                <tr>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-default-dark text-sm sm:text-base capitalize whitespace-pre-wrap">
                        Jaminan</td>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-default-dark text-sm sm:text-base capitalize whitespace-pre-wrap font-semibold">
                        {{ sewa.jaminan }}</td>
                </tr>
                <tr>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-default-dark text-sm sm:text-base capitalize whitespace-pre-wrap">
                        Tanggal sewa</td>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-default-dark text-sm sm:text-base capitalize whitespace-pre-wrap font-semibold">
                        {{ sewa.waktusewa.tgl_sewa }}</td>
                </tr>
                <tr>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-default-dark text-sm sm:text-base capitalize whitespace-pre-wrap">
                        Tanggal Kembali</td>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-default-dark text-sm sm:text-base capitalize whitespace-pre-wrap font-semibold">
                        {{ sewa.waktusewa.tgl_kembali }}</td>
                </tr>
                <tr>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-default-dark text-sm sm:text-base capitalize whitespace-pre-wrap">
                        Lama Sewa</td>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-default-dark text-sm sm:text-base capitalize whitespace-pre-wrap font-semibold">
                        {{ sewa.waktusewa.lama_sewa }} Hari</td>
                </tr>
                <tr>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-default-dark text-sm sm:text-base capitalize whitespace-pre-wrap">
                        Jumlah Telat Per Jam </td>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-default-dark text-sm sm:text-base capitalize whitespace-pre-wrap font-semibold">
                        {{ sewa.waktusewa.telat }} JAM</td>
                </tr>
                <tr>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-default-dark text-sm sm:text-base capitalize whitespace-pre-wrap">
                        Jumlah Bayar</td>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-default-dark text-sm sm:text-base capitalize whitespace-pre-wrap font-semibold">
                        Rp. {{ reduceArray(sewa.harga,sewa.waktusewa.lama_sewa ) }} </td>
                </tr>
                <tr>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-default-dark text-sm sm:text-base capitalize whitespace-pre-wrap">
                        Denda</td>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-default-dark text-sm sm:text-base capitalize whitespace-pre-wrap font-semibold">
                        Rp. {{ reduceArray(sewa.denda) }} </td>
                </tr>
                <tr>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-default-dark text-sm sm:text-base capitalize whitespace-pre-wrap">
                        Panjar</td>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-default-dark text-sm sm:text-base capitalize whitespace-pre-wrap font-semibold">
                        Rp. {{ Number(sewa.panjar) }} </td>
                </tr>
                <tr>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-default-dark text-sm sm:text-base capitalize whitespace-pre-wrap">
                        Sisa Pembayaran</td>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-default-dark text-sm sm:text-base capitalize whitespace-pre-wrap font-semibold">
                        Rp. {{ Number(sewa.sisa).toLocaleString() }} </td>
                </tr>
                <tr>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-default-dark text-sm sm:text-base capitalize whitespace-pre-wrap">
                        Total Bayar</td>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-default-dark text-sm sm:text-base capitalize whitespace-pre-wrap font-semibold">
                        Rp. {{ reduceArray(sewa.harga , sewa.waktusewa.lama_sewa, sewa.denda) }} </td>
                </tr>
                <tr>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-default-dark text-sm sm:text-base capitalize whitespace-pre-wrap">
                        Status Pembayaran</td>
                    <td
                        class=" border border-gray-200 md:px-3 sm:py-2 p-1 text-default-dark text-sm sm:text-base capitalize whitespace-pre-wrap font-semibold">
                        {{ statusBayar(sewa.status_bayar) }} </td>
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
    setup(){
        function reduceArray(array = [], lamasewa = 1, denda = 0) {
            var sisa = array.split(',');
            var harga = sisa.reduce((el, b) => Number(el) + Number(b));
            var total = (parseInt(harga) * lamasewa) + parseInt(denda);
            return Number(total).toLocaleString();
        }
        return {reduceArray}
    },
    props: {
        sewa: {
            type: Object,
            default: () => ({})
        },
    },
    mounted(){

    },
    methods: {
        back() {
            window.history.back();
        },
        statusBayar(value){
            var hasil = null;
            switch (value) {
                case '1' || 1:
                    hasil = 'Lunas'
                    break;
                case '2' || 2:
                    hasil = 'Denda'
                    break;
                case '3' || 3:
                    hasil = 'Belum Lunas'
                    break;
                case '4' || 4:
                    hasil = 'Menunggak Pembayaran'
                    break;

                default:
                    hasil = 'error'
                    break;
            }
            return hasil;
        }
    },


}
</script>
