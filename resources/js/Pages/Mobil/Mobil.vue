<script setup>
import { defineProps, ref, onMounted, defineEmits } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import Modal from '@/Components/Modal.vue'
const props = defineProps({
    mobil: Object,
    TabStatus: Object.toString()
})
const form = useForm();
function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route('Mobil.destroy', id));
    }
}
let Tab = 0;
var TabActive = ' py-4 px-2 md:px-6 block hover:text-blue-500 focus:outline-none text-blue-500 border-b-2 font-medium border-blue-500'
var TabNonActive = 'text-gray-600 py-4 px-2 md:px-6 block hover:text-blue-500 focus:outline-none';
function TabClick(num) {
    form.get(route('Mobil.index', { status: num }))
}

// Modal
var ModalShow = ref(false);
const StatusForm = useForm({
    status: "",
})
function isOpen() {
    ModalShow = true;
}
</script>

<template>
    <AuthenticatedLayout>

        <Head title="Mobil" />

        <!-- Modal toggle -->
        <Modal :show="ModalShow" @close="ModalShow = false">
            Hai
        </Modal>

        <div
            class="w-full rounded-lg bg-gray-200 flex flex-wrap justify-between flex-col-reverse md:flex-row overflow-auto">
            <nav class="flex flex-row">
                <button v-on:click="ModalShow =true" v-bind:class="Tab == '0' ? TabActive : TabNonActive">
                    Semua
                </button><button v-on:click="TabClick(1)" v-bind:class="Tab == 1 ? TabActive : TabNonActive">
                    Disewa
                </button><button v-on:click="TabClick(2)" v-bind:class="Tab == '2' ? TabActive : TabNonActive">
                    Tersedia
                </button><button v-on:click="TabClick(3)" v-bind:class="Tab == 3 ? TabActive : TabNonActive">
                    Perbaikan
                </button>
            </nav>
            <div class="p-3 w-32">
                <Link :href="route('Mobil.create')"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 cursor-pointer">
                Tambah</Link>
            </div>
        </div>
        <div class="w-full overflow-hidden rounded-lg shadow-lg">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Unit Kendaraan</th>
                            <th class="px-4 py-3">No. Polisi</th>
                            <th class="px-4 py-3">Harga</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Detail</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <tr v-for="mobil in mobil" :key="mobil" class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-sm">
                                {{ mobil.unit }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ mobil.nopol }}
                            </td>
                            <td class="px-4 py-3 text-xs">
                                {{ mobil.harga }}
                            </td>
                            <td class="px-4 py-3 text-xs ">
                                <Link :href="route('Mobil.StatusModal')"
                                    class="px-2 py-1 font-semibold cursor-pointer capitalize leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                    {{ Status(mobil.status) }}
                                </Link>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <button class="bg-blue-700 text-white px-2 py-1 rounded-md ml-2">
                                    <Link
                                        :href="route('Mobil.show', [{ id: mobil.id, search: mobil.unit + mobil.nopol }])">

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    </Link>
                                </button>
                                <button @click="destroy(mobil.id)"
                                    class="bg-default-red text-white px-2 py-1 rounded-md ml-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>

                                </button>
                                <button class=" bg-green-600 text-white px-2 py-1 rounded-md ml-2">
                                    <Link :href="route('Mobil.edit', [{ id: mobil.id }])">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                    </Link>
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
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
export default {
    name: 'MobilVue',
    components: {
        AuthenticatedLayout
    },
    data() {
        return {
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
    methods: {

        Status(n) {
            var msg = '';
            switch (n) {
                case 1:
                    msg = 'siap'
                    break;
                case 2:
                    msg = 'disewa'
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

    },
    mounted() {
    }
}
</script>
