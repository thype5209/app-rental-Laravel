
<script setup>
import { ref } from 'vue';
import { Head,Link } from '@inertiajs/inertia-vue3';
</script>


<template>
    <AuthenticatedLayout>
        <Head title="Sewa Form"/>
        <div class="w-full rounded-lg bg-gray-200 flex flex-wrap justify-between flex-col-reverse md:flex-row overflow-auto">
            <nav class="flex flex-row">
                <button v-on:click="TabClick(0)" v-bind:class=" Tab == '0' ? TabActive : TabNonActive">
                    Semua
                </button>
                <button v-on:click="TabClick(1)" v-bind:class="Tab == '1' ? TabActive : TabNonActive">
                    Telat
                </button>
                <button v-on:click="TabClick(2)" v-bind:class="Tab == '2' ? TabActive : TabNonActive">
                    Sewa
                </button>
            </nav>
            <div class="p-3 w-32">
                <Link :href="route('Sewa.create')"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Tambah</Link>
            </div>
        </div>
        <div class="w-full overflow-hidden rounded-lg shadow-lg">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b  bg-gray-50">
                            <th class="md:px-4 md:py-3 px-2 py-1 text-xs whitespace-nowrap">Unit Kendaraan</th>
                            <th class="md:px-4 md:py-3 px-2 py-1 text-xs whitespace-nowrap">No. Polisi</th>
                            <th class="md:px-4 md:py-3 px-2 py-1 text-xs whitespace-nowrap">Nama Penyewa</th>
                            <th class="md:px-4 md:py-3 px-2 py-1 text-xs whitespace-nowrap">NIK Penyewa</th>
                            <th class="md:px-4 md:py-3 px-2 py-1 text-xs whitespace-nowrap">Tanggal Sewa</th>
                            <th class="md:px-4 md:py-3 px-2 py-1 text-xs whitespace-nowrap">Tanggal Kembali</th>
                            <th class="md:px-4 md:py-3 px-2 py-1 text-xs whitespace-nowrap">Status</th>
                            <th class="md:px-4 md:py-3 px-2 py-1 text-xs whitespace-nowrap">Detail</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <tr v-for="mobil in sewa" :key="mobil" class="text-gray-700 dark:text-gray-400">
                            <td class="md:px-4 md:py-3 px-2 py-2 text-sm">
                                {{ mobil.unit }}
                            </td>
                            <td class="md:px-4 md:py-3 px-2 py-2 text-sm">
                                {{ mobil.nopol }}
                            </td>
                            <td class="md:px-4 md:py-3 px-2 py-2 text-sm">
                                {{ mobil.nama_penyewa }}
                            </td>
                            <td class="md:px-4 md:py-3 px-2 py-2 text-sm">
                                {{ mobil.nik }}
                            </td>
                            <td class="md:px-4 md:py-3 px-2 py-2 text-sm">
                                {{ mobil.tgl_sewa }}
                            </td>
                            <td class="md:px-4 md:py-3 px-2 py-2 text-sm">
                                {{ mobil.tgl_kembali }}
                            </td>
                            <td class="md:px-4 md:py-3 px-2 py-2 text-xs">
                                <span
                                    class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                    {{ Status(mobil.status) }}
                                </span>
                            </td>
                            <td class="md:px-4 md:py-3 px-2 py-2 text-sm">
                                <button class="bg-blue-700 text-white px-2 py-1 rounded-md ml-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </button>
                                <button class="bg-default-red text-white px-2 py-1 rounded-md ml-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>

                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

export default {
    name: 'MobilVue',
    components: {
        AuthenticatedLayout
    },
    data() {
        return {
            Tab: 0,
            TabActive: '',
            TabNonActive: '',
            txt: '',
            unit: '',
            nopol: '',
            fotodepan: '',
            fotobelakang: '',
            fotokiri: '',
            fotokanan: '',
            status: '',
        }
    },
    beforeMount() {
        this.Tab = 1;
        this.TabActive = 'py-4 px-2 md:px-6 block hover:text-blue-500 focus:outline-none text-blue-500 border-b-2 font-medium border-blue-500'
        this.TabNonActive = 'text-gray-600 py-4 px-2 md:px-6 block hover:text-blue-500 focus:outline-none'
    },
    methods: {
        TabClick: function (num) {

            return this.Tab = num;

        },
        Status(n) {
            var msg = '';
            switch (n) {
                case '1':
                    msg = 'Sewa'
                    break;
                case '2':
                    msg = 'Telat'
                    break;
                default:
                    msg = 'semua'
                    break;
            }
            return msg;
        }

    },
    mounted() {
    },
    props:{
        sewa:{
            type: Object,
            default: ()=>({})
        }
    }
}
</script>
