<template>
    <AuthenticatedLayoutVue>

        <Head title="Laporan" />
        <div class="container bg-gray-200 rounded-t-md">

            <!-- Date -->

            <div>
                <form @submit.prevent="submit" class="flex flex-col md:flex-row items-center max-w-max gap-5 w-full py-3 ml-3">
                    <div class=" flex justify-center items-center gap-5">
                        <InputLabelVue for="simple-search" class=" whitespace-nowrap">Tanggal Awal </InputLabelVue>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                                </svg>

                            </div>
                            <input type="date" id="simple-search" v-model="formDate.min"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Search" />
                        </div>
                    </div>
                    <div class=" flex justify-center items-center gap-5">
                        <InputLabelVue for="simple-search" class=" whitespace-nowrap">Tanggal AKhir </InputLabelVue>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                                </svg>

                            </div>
                            <input type="date" id="simple-search" v-model="formDate.max"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Search" />
                        </div>
                    </div>
                    <PrimaryButtonVue>Cari</PrimaryButtonVue>
                </form>
            </div>

            <div class="ml-5 py-3" v-if="cetak">
                <div class="inline-flex rounded-md shadow-sm" role="group">
                    <button type="button" @click="cetakEXCEL"
                        class="inline-flex items-center py-2 px-4 text-sm font-medium text-gray-900 bg-white rounded-l-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" class='w-5 h-5' viewBox="0 0 48 48">
                            <path fill="#4CAF50" d="M41,10H25v28h16c0.553,0,1-0.447,1-1V11C42,10.447,41.553,10,41,10z">
                            </path>
                            <path fill="#FFF"
                                d="M32 15H39V18H32zM32 25H39V28H32zM32 30H39V33H32zM32 20H39V23H32zM25 15H30V18H25zM25 25H30V28H25zM25 30H30V33H25zM25 20H30V23H25z">
                            </path>
                            <path fill="#2E7D32" d="M27 42L6 38 6 10 27 6z"></path>
                            <path fill="#FFF"
                                d="M19.129,31l-2.411-4.561c-0.092-0.171-0.186-0.483-0.284-0.938h-0.037c-0.046,0.215-0.154,0.541-0.324,0.979L13.652,31H9.895l4.462-7.001L10.274,17h3.837l2.001,4.196c0.156,0.331,0.296,0.725,0.42,1.179h0.04c0.078-0.271,0.224-0.68,0.439-1.22L19.237,17h3.515l-4.199,6.939l4.316,7.059h-3.74V31z">
                            </path>
                        </svg>
                        EXCEL
                    </button>
                    <button type="button" @click="parseCetak(false)"
                        class="border inline-flex items-center py-2 px-4 text-sm font-medium text-white bg-default-blue border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                        <svg aria-hidden="true" class="mr-2 w-4 h-4 fill-current" fill="currentColor"
                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M2 9.5A3.5 3.5 0 005.5 13H9v2.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 15.586V13h2.5a4.5 4.5 0 10-.616-8.958 4.002 4.002 0 10-7.753 1.977A3.5 3.5 0 002 9.5zm9 3.5H9V8a1 1 0 012 0v5z"
                                clip-rule="evenodd"></path>
                        </svg>
                        PDF
                    </button>
                    <button type="button" @click="DeleteAllDanSave('Hapus Dan Download File')"
                        class="border inline-flex items-center py-2 px-4 text-sm font-medium text-white bg-green-500 border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                        <svg aria-hidden="true" class="mr-2 w-4 h-4 fill-current" fill="currentColor"
                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M2 9.5A3.5 3.5 0 005.5 13H9v2.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 15.586V13h2.5a4.5 4.5 0 10-.616-8.958 4.002 4.002 0 10-7.753 1.977A3.5 3.5 0 002 9.5zm9 3.5H9V8a1 1 0 012 0v5z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Downloads File PDF dan Hapus
                    </button>
                    <button type="button" @click="DeleteAll('Hapus Semua')"
                    class="inline-flex bg-red-500 text-white items-center py-2 px-4 text-sm font-medium  rounded-r-md border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                        </path>
                    </svg>
                    Hapus Semua
                </button>
                </div>

            </div>
            <progress max="100" :value.prop="uploadPercentage"></progress>
            <!-- Endsearch -->


            <!-- TABLE -->
            <div class="w-full overflow-hidden rounded-lg shadow-lg flex flex-col">
                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr
                                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                                <!-- <th scope="col" class="p-4" @click="centangFileAll">
                                    <div class="flex items-center">
                                        Mo.
                                    </div>
                                </th> -->
                                <th class="p-1.5 text-xs whitespace-nowrap border text-center">No.</th>
                                <th class="p-1.5 text-xs whitespace-nowrap border text-center">Kode</th>
                                <th class="p-1.5 text-xs whitespace-nowrap border text-center">NIK</th>
                                <th class="p-1.5 text-xs whitespace-nowrap border text-center">Nama Penyewa</th>
                                <th class="p-1.5 text-xs whitespace-nowrap border text-center">No. Polisi</th>
                                <th class="p-1.5 text-xs whitespace-nowrap border text-center">Tanggal Sewa</th>
                                <th class="p-1.5 text-xs whitespace-nowrap border text-center">Tanggal Kembali</th>
                                <th class="p-1 text-[0.67rem] whitespace-pre border">Penanggung Jawab</th>
                                <th class="p-1 text-[0.67rem] whitespace-pre border">Total</th>
                                <!-- <th class="p-1.5 text-xs whitespace-nowrap border text-center">Status</th> -->
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            <tr v-for="(mobil, index) in data.sewa" :key="mobil" :index="index"
                                class="text-gray-700 dark:text-gray-400">
                                <!-- <td class="p-4 w-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-table-search-1" name="mycheckboxes" type="checkbox"
                                            v-model="valueCheck" :value="mobil.id"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                    </div>
                                </td> -->
                                <td class="md:px-2 md:py-1 p-1.5 text-center text-xs md:text-[0.80rem] border">{{ (index + 1)}}</td>

                                <td class="md:px-2 md:py-1 p-1.5 text-center text-xs md:text-[0.80rem] border">{{mobil.kode}}</td>
                                <td class="md:px-2 md:py-1 p-1.5 text-center text-xs md:text-[0.80rem] border">
                                    <span v-if="mobil.nik != null">{{ mobil.nik }}</span>
                                    <span v-else>---------</span>
                                </td>
                                <td class="md:px-2 md:py-1 p-1.5 text-center text-xs md:text-[0.80rem] border"
                                    v-if="mobil.pengguna != null">{{mobil.pengguna.nama}}</td>
                                <td class="md:px-2 md:py-1 p-1.5 text-center text-xs md:text-[0.80rem] border" v-else>
                                    Sopir</td>
                                <td class="md:px-2 md:py-1 p-1.5 text-center text-xs md:text-[0.80rem] border">{{mobil.nopol}}</td>
                                <td class="md:px-2 md:py-1 p-1.5 text-center text-xs md:text-[0.80rem] border">{{mobil.waktusewa.tgl_sewa}}</td>
                                <td class="md:px-2 md:py-1 p-1.5 text-center text-xs md:text-[0.80rem] border">
                                    {{ mobil.waktusewa.tgl_kembali }}
                                    <br />
                                </td>
                                <td class="md:px-2 md:py-1 p-1.5 text-center text-xs md:text-[0.80rem] border">
                                    {{ mobil.user.name }}</td>
                                <td class="md:px-2 md:py-1 p-1.5 text-center text-xs md:text-[0.80rem] border">
                                    {{ rupiah(mobil.total) }}</td>

                                <!-- <td class="md:px-4 md:py-3 px-2 py-2 text-xs border">
                                    <span
                                        class="px-2 py-1 font-semibold cursor-pointer leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">{{mobil.status}}</span>
                                </td> -->
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayoutVue>
</template>
<script setup>
import AuthenticatedLayoutVue from '../../Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/inertia-vue3';
import { defineProps, ref, watch } from 'vue';
import InputLabelVue from '@/Components/InputLabel.vue';
import PrimaryButtonVue from '@/Components/PrimaryButton.vue';
import axios from 'axios';
import PaginationVue from '@/Components/Pagination.vue';
import { SaveAs } from 'file-saver';
import Swal from 'sweetalert2';
const data = defineProps({
    sewa: {
        type: Object,
        default: () => ({})
    }
})
const rupiah = (number) => {
            return new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR"
            }).format(number);
        }
const formDate = useForm({
    min: '',
    max: ''
});
const cetak = ref(true)
const checkbox = ref(false);

function submit() {
    formDate.get(route('Laporan.index', { min: formDate.min, max: formDate.max }), {
        preserveState: true,
        preserveScroll: true,
    })
    cetak.value = true;
}

const uploadPercentage = ref(0);
let config = {
    responseType: 'blob',
    onDownloadProgress: function (progressEvent) {
        uploadPercentage.value = Math.round((progressEvent.loaded * 100) / progressEvent.total)
        // console.log(uploadPercentage.value) // this works fine but how do I update the initial value from here?
    }
}
function cetakEXCEL(e) {
    // console.log(uploadPercentage.value)

    axios
        .get(route('Laporan.CetakEXCEL', { min: formDate.min, max: formDate.max }), config)
        .then(response => {
            // console.log(response)
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', 'file.xlsx');
            document.body.appendChild(link);
            link.click();
            // Mostly the same, I was just experimenting with different approaches, tried link.click, iframe and other solutions
        }).catch(error => console.log(error))
}
function cetakPDF() {

    console.log(uploadPercentage.value)

    axios
        .get(route('Laporan.CetakPDF', { min: formDate.min, max: formDate.max }), config)
        .then(response => {
            // console.log(response)
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', 'file.pdf');
            document.body.appendChild(link);
            link.click();
            // Mostly the same, I was just experimenting with different approaches, tried link.click, iframe and other solutions
        }).catch(error => console.log(error))
}

// Fungsi Centang File
const valueCheck = ref([])
function centangFile() {
    checkbox.value = !checkbox.value;
}
function centangFileAll() {
    centangFile()
    var ch = document.getElementsByName('mycheckboxes');
    ch.forEach((elem) => {
        elem.checked = checkbox.value;
        if (elem.checked) {
            valueCheck.value.push(elem.value)
        } else {
            valueCheck.value = [];
        }
    })
    // console.log(valueCheck.value)
}
watch(valueCheck, (value) => {
    console.log(value)
})
function parseCetak(value) {
    axios.get(route('Laporan.cekDowloadFile', { min: formDate.min, max: formDate.max }), config)
        .then(response => {
            console.log(response)
            // SaveAs(response.data,'file.zip')
            const url = URL.createObjectURL(new Blob([response.data], { type: 'application/zip' }));
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', 'arsip.zip');
            document.body.appendChild(link);
            link.click();
            URL.revokeObjectURL(link.href)
            // Mostly the same, I was just experimenting with different approaches, tried link.click, iframe and other solutions
        }).catch(error => console.log(error))
}

function DeleteAllDanSave(txt) {
    Swal.fire({
        title: txt,
        text: "Apakah Anda Yakin?",
        icon: "warning",
        showDenyButton: true,
        confirmButtonColor: "#3338ED",
        denyButtonColor: "#CF4647",
        confirmButtonText: 'Simpan',
        denyButtonText: 'Batal',

    })
        .then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                axios.get(route('Laporan.cekDowloadFile', { data: valueCheck.value, clear: true }), config)
                    .then(response => {
                        // console.log(response)
                        const url = window.URL.createObjectURL(new Blob([response.data]));
                        const link = document.createElement('a');
                        link.href = url;
                        link.setAttribute('download', 'file.zip');
                        document.body.appendChild(link);
                        link.click();
                        window.location.reload;
                        // Mostly the same, I was just experimenting with different approaches, tried link.click, iframe and other solutions
                    }).catch(error => console.log(error))
            } else if (result.isDenied) {
                Swal.fire('Dibatalkan', '', 'info')
            }
        })
}
function DeleteAll(txt) {
    Swal.fire({
        title: txt,
        text: "Apakah Anda Yakin?",
        icon: "warning",
        showDenyButton: true,
        confirmButtonColor: "#3338ED",
        denyButtonColor: "#CF4647",
        confirmButtonText: 'Simpan',
        denyButtonText: 'Batal',

    })
        .then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                axios.get(route('Laporan.destroyAll', { data: valueCheck.value }))
                    .then((response) => {
                        Swal.fire(
                            response.data,
                            'You clicked the button!',
                            'success'
                        )
                        window.location.reload
                        // Mostly the same, I was just experimenting with different approaches, tried link.click, iframe and other solutions
                    }).catch(error => console.log(error))
            } else if (result.isDenied) {
                Swal.fire('Dibatalkan', '', 'info')
            }
        })
}
</script>
