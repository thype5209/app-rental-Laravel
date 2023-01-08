<script setup>
import AuthenticatedLayoutVue from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage, useForm } from '@inertiajs/inertia-vue3';
import { defineProps, computed } from 'vue';
import PrimaryButtonVue from '@/Components/PrimaryButton.vue';

const data = defineProps({
    formulir: {
        type: Object,
        default: () => ({})
    },
    data: {
        type: Object,
        default: () => ({})
    },
    kode: Object.toString(),

})

const FormPDF = useForm({
    jenis_sewa: data.formulir.jenis_sewa,
    foto_ktp: data.formulir.foto_ktp,
    sopir_id: data.formulir.sopir_id,
    mobil_id: data.formulir.mobil_id,
    nik: data.formulir.nik,
    nama: data.formulir.nama,
    tempat_lahir: data.formulir.tempat_lahir,
    tgl_lahir: data.formulir.tgl_lahir,
    alamat: data.formulir.alamat,
    pekerjaan: data.formulir.pekerjaan,
    sosial: data.formulir.sosial,
    no_hp: data.formulir.no_hp,
    no_hp_lain: data.formulir.no_hp_lain,
    nilaisewahari: data.formulir.nilaisewahari,
    nilaisewabulan: data.formulir.nilaisewabulan,
    tgl_sewa: data.formulir.tgl_sewa,
    tgl_kembali: data.formulir.tgl_kembali,
    lama_sewa: data.formulir.lama_sewa,
    tujuan: data.formulir.tujuan,
    jaminan: data.formulir.jaminan,
    unit: data.formulir.unit,
    nopol: data.formulir.nopol,
    tahun: data.formulir.tahun,
    panjar: data.formulir.panjar,
    sisa: data.formulir.sisa,
    lunas: data.formulir.lunas,
    jam_sewa: data.formulir.jam_sewa,
    jam_kembali: data.formulir.jam_kembali,
    ket_syarat: data.formulir.ket_syarat,
    list_pengiriman: data.formulir.list_pengiriman,
    metode_bayar: data.formulir.metode_bayar,
})


const date = new Date();
const today = `${date.getUTCDate()} ${parseMonth(date.getMonth())}, ${date.getFullYear()}`

function parseMonth(value) {
    var msg = '';
    switch (value) {
        case 1:
            msg = 'Januari';
            break;
        case 2:
            msg = 'Februari';
            break;
        case 3:
            msg = 'Maret';
            break;
        case 4:
            msg = 'April';
            break;
        case 5:
            msg = 'Mei';
            break;
        case 6:
            msg = 'Juni';
            break;
        case 7:
            msg = 'Juli';
            break;
        case 8:
            msg = 'Agustus';
            break;
        case 9:
            msg = 'September';
            break;
        case 10:
            msg = 'Oktober';
            break;
        case 11:
            msg = 'November';
            break;
        case 12:
            msg = 'Desember';
            break;

        default:
            msg = 'Error'
            break;
    }
    return msg;
}

function cetakDanSave() {
    FormPDF.post(route('Laporan.saveSewa'), {
        preserveState: false,
        replace: false,
        onSuccess: () => {
            window.location.href = '/Laporan/CetakSewa?pdf=SewaPDF/' + data.kode + "-" + FormPDF.tgl_sewa + '.pdf&&kode=' + data.kode;
            FormPDF.reset();
        },
    });
}
const jumlahMobil = FormPDF.nopol.length;
console.log(jumlahMobil)
</script>

<template>
    <AuthenticatedLayoutVue class="bg-gray-200">

        <Head title="Formulir Sewa Mobil" />
        <PrimaryButtonVue>
            <Link :href="route('Sewa.create')" :data="{ FormPDF }">Kembali</Link>
        </PrimaryButtonVue>
        <form @submit.prevent="cetakDanSave()"
            class="bg-gray-200 container mx-auto md:px-10 flex flex-col justify-center items-center">
            <section class=" md:w-[70%] py-5 px-3 bg-white sm:px-10 md:px-20">
                <!-- Head -->
                <div
                    class="bg-white flex justify-center gap-4 opacity-80 border-b-4 border-black border-opacity-80 py-5">
                    <div class="">
                        <img :src="`/img/logo.png`" class="w-32 sm:w-32 h-full" alt="">
                    </div>
                    <div>
                        <ul class=" flex flex-col justify-center text-center">
                            <li class="text-orange-500 font-bold">CV. JASA SAUDAGAR</li>
                            <li class="font-bold text-base">JL. MASJID RAYA No. 72 A Kab. GOWA</li>
                            <li><span>Tlp( 0411 )8985984, mobile 0811 4145 999</span></li>
                            <li>
                                <span>Email : <a class="text-blue-500"
                                        href="mailto:cvjasasaudagar@gmail.com">cvjasasaudagar@gmail.com</a>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>

                <table class="table w-full bg-white mb-5">
                    <tr class=" p-0 m-0">
                        <td colspan="4" class="text-center flex flex-col justify-center  ">
                            <span class="text-center font-bold underline">SURAT PERNYATAAN SEWA KENDARAAN</span>
                            <span class="font-semibold text-center">No: {{ data.kode }}</span>
                        </td>
                    </tr>


                </table>

                <table class="table w-max sm:w-1/4 md:w-1/3 mb-5 text-left">

                    <tr class=" p-0 m-0">
                        <td class=" whitespace-nowrap mb-0 p-0">NIK</td>
                        <td class=" whitespace-nowrap mb-0 p-0">: <input type="text" name="nik" v-model="FormPDF.nik"
                                class="border-none text-xs p-0 m-0"></td>
                    </tr>
                    <tr class=" p-0 m-0">
                        <td class=" whitespace-nowrap mb-0 p-0">Nama</td>
                        <td class=" whitespace-nowrap mb-0 p-0">: <input type="text" name="nama" v-model="FormPDF.nama"
                                class="border-none text-xs p-0 m-0 capitalize"></td>
                    </tr>
                    <tr class=" p-0 m-0">
                        <td class=" whitespace-nowrap mb-0 p-0">Tempat/Tanggal Lahir</td>
                        <td class=" whitespace-nowrap mb-0 p-0">: <input type="text" name="tempat_lahir"
                                v-model="FormPDF.tempat_lahir" class="border-none text-xs p-0 m-0 w-16 max-w-max ">/
                            <input type="text" name="nik" v-model="FormPDF.tgl_lahir"
                                class="border-none text-xs p-0 m-0">
                        </td>
                    </tr>
                    <tr class=" p-0 m-0">
                        <td class=" whitespace-nowrap mb-0 p-0">Pekerjaan</td>
                        <td class=" whitespace-nowrap mb-0 p-0">: <input type="text" name="nik"
                                v-model="FormPDF.pekerjaan" class="border-none text-xs p-0 m-0 w-max max-w-max "></td>
                    </tr>
                    <tr class=" p-0 m-0">
                        <td class=" whitespace-nowrap mb-0 p-0">Alamat</td>
                        <td class=" whitespace-nowrap mb-0 p-0">: <input type="text" name="nik" v-model="FormPDF.alamat"
                                class="border-none text-xs p-0 m-0 w-max max-w-max "></td>
                    </tr>
                    <tr class=" p-0 m-0">
                        <td class=" whitespace-nowrap mb-0 p-0">No. HP</td>
                        <td class=" whitespace-nowrap mb-0 p-0">: <input type="text" name="nik" v-model="FormPDF.no_hp"
                                class="border-none text-xs p-0 m-0 w-max max-w-max "> </td>
                    </tr>
                    <tr class=" p-0 m-0">
                        <td class=" whitespace-nowrap mb-0 p-0">No. HP Kerabat Lain</td>
                        <td class=" whitespace-nowrap mb-0 p-0">: <input type="text" name="nik"
                                v-model="FormPDF.no_hp_lain" class="border-none text-xs p-0 m-0 w-max max-w-max "> </td>
                    </tr>
                    <tr class=" p-0 m-0">
                        <td class=" whitespace-nowrap mb-0 p-0">Sosial Media</td>
                        <td class=" whitespace-nowrap mb-0 p-0">: <input type="text" name="nik" v-model="FormPDF.sosial"
                                class="border-none text-xs p-0 m-0 w-max max-w-max " /> </td>
                    </tr>
                </table>
                <p class="w-full text-justify font-bold mb-3">Dengan ini menyatakan bahwa pihak rental menitipkan
                    kendaraan
                    kepada saya dengan spesipikasi kendaraan sebagai berikut.</p>

                <table class="table w-max sm:w-1/4 md:w-1/2 mb-5 h-max text-justify " v-for="(item,index) in jumlahMobil" :key="item" :index="index">
                    <tr class=" p-0 m-0">
                        <td class=" whitespace-nowrap mb-0 p-0 font-bold">Jenis Kendaraan</td>
                        <td class=" whitespace-nowrap mb-0 p-0">
                            <span class="font-bold">:</span> {{ FormPDF.unit[index] }}
                        </td>
                    </tr>
                    <tr class=" p-0 m-0">
                        <td class=" whitespace-nowrap mb-0 p-0 font-bold">No. Polisi</td>
                        <td class=" whitespace-nowrap mb-0 p-0"><span class="font-bold">:</span> {{ FormPDF.nopol[index] }}
                        </td>
                    </tr>
                    <tr class=" p-0 m-0">
                        <td class=" whitespace-nowrap mb-0 p-0 font-bold">Tahun</td>
                        <td class=" whitespace-nowrap mb-0 p-0"><span class="font-bold">:</span> {{ FormPDF.tahun[index] }}
                        </td>
                    </tr>
                    <tr class=" p-0 m-0">
                        <td class=" whitespace-nowrap mb-0 p-0 font-bold">Nilai Sewa</td>
                        <td>
                            <ul class="list-none flex flex-row gap-4">
                                <li class=" whitespace-nowrap mb-0 p-0"><span class="font-bold">:</span> Rp. {{
                                    FormPDF.nilaisewahari[index]
                                }}/Per Hari</li>
                                <li class=" whitespace-nowrap mb-0 p-0"><span class="font-bold">:</span> Rp. {{
                                    FormPDF.nilaisewabulan[index]
                                }}/Per Bulan</li>
                            </ul>
                        </td>
                    </tr>

                </table>
                <table class="table w-max sm:w-1/4 md:w-1/2 mb-5 h-max text-justify ">
                    <tr class=" p-0 m-0">
                        <td class=" whitespace-nowrap mb-0 p-0 font-bold">Tanggal/Jam Sewa</td>
                        <td class=" whitespace-nowrap mb-0 p-0"><span class="font-bold">:</span> {{ FormPDF.tgl_sewa }}/{{ FormPDF.jam_sewa }} WITA
                        </td>
                    </tr>
                    <tr class=" p-0 m-0">
                        <td class=" whitespace-nowrap mb-0 p-0 font-bold">Tanggal/Jam Kembali</td>
                        <td class=" whitespace-nowrap mb-0 p-0"><span class="font-bold">:</span> {{ FormPDF.tgl_kembali }}/{{ FormPDF.jam_kembali }} WITA
                        </td>
                    </tr>
                    <tr class=" p-0 m-0">
                        <td class=" whitespace-nowrap mb-0 p-0 font-bold">Jumlah Hari</td>
                        <td class=" whitespace-nowrap mb-0 p-0"><span class="font-bold">:</span> {{ FormPDF.lama_sewa }}
                            Hari
                        </td>
                    </tr>
                    <tr class=" p-0 m-0">
                        <td class=" whitespace-nowrap mb-0 p-0 font-bold">Tujuan</td>
                        <td class=" whitespace-nowrap mb-0 p-0 "><span class="font-bold">:</span> {{ FormPDF.tujuan }}
                        </td>
                    </tr>
                    <tr class=" p-0 m-0">
                        <td class=" whitespace-nowrap mb-0 p-0 font-bold">Jaminan</td>
                        <td class=" whitespace-nowrap mb-0 p-0 "><span class="font-bold">:</span> {{ FormPDF.jaminan }}
                        </td>
                    </tr>
                </table>

                <!-- Keterangan -->
                <div class="" v-html="FormPDF.ket_syarat">
                </div>
                <!-- Panjar -->
                <table class="table ml-10 mt-5 border">
                    <tr>
                        <th class="py-1 px-2 capitalize bg-blue-200 border border-black">Panjar</th>
                        <th class="py-1 px-2 capitalize bg-blue-200 border border-black">Sisa</th>
                        <th class="py-1 px-2 capitalize bg-blue-200 border border-black">Lunas</th>
                    </tr>
                    <tr>
                        <td class="border border-black"> {{ FormPDF.panjar }} </td>
                        <td class="border border-black"> {{ FormPDF.sisa }}</td>
                        <td class="border border-black">
                            <svg v-if="FormPDF.lunas == 'true'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                            <svg v-else-if="FormPDF.lunas == 'false'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </td>
                    </tr>
                </table>
                <!-- TTD -->
                <table class="table w-full mt-10 ">
                    <tr>
                        <td colspan="3" class="text-right"> Makassar, {{ today }}</td>
                    </tr>
                    <tr>
                        <td class="text-center">Direktur CV. JASA SAUDAGAR</td>

                        <td>&nbsp;</td>

                        <td class="text-center">YANG MEMBUAT PERNYATAAN</td>
                    </tr>
                    <tr>
                        <td class="text-center"></td>

                        <td>&nbsp;</td>

                        <td class="text-center"></td>
                    </tr>
                    <tr>
                        <td class="text-center h-10 "><span
                                class="border-b-2 border-black">(..................................)</span></td>
                        <td class="text-center h-10 "><span
                                class="border-b-2 border-black">(..................................)</span></td>
                        <td class="text-center h-10 "><span
                                class="border-b-2 border-black">(..................................)</span></td>
                    </tr>
                    <tr>
                        <td class="text-center">Yang Menyerahkan Kendaraan</td>

                        <td class="text-center">Saksi</td>

                        <td class="text-center">Penyewa</td>
                    </tr>
                </table>
            </section>
            <PrimaryButtonVue type="submit" class=" w-1/2 text-center flex justify-center">Cetak</PrimaryButtonVue>
        </form>
    </AuthenticatedLayoutVue>
</template>

<style>
section * {
    font-size: 12px;
}
</style>
