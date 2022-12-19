<script setup>
import { defineProps, ref, onMounted, defineEmits } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import InputLabelVue from '@/Components/InputLabel.vue';
import TextInputVue from '@/Components/TextInput.vue';
import DropdownVue from '@/Components/Dropdown.vue';
import TrVue from '@/Components/Tr.vue'
import TdVue from '@/Components/Td.vue'
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
var TabActive = ' py-4 px-2 md:px-6 block hover:text-blue-500 focus:outline-none text-blue-500 border-b-2 font-medium border-blue-500'
var TabNonActive = 'text-gray-600 py-4 px-2 md:px-6 block hover:text-blue-500 focus:outline-none';
function TabClick(num) {
    form.get(route('Mobil.index', { status: num }))
}

// Modal
var ModalShow = ref(false);
var StatusForm = useForm({
    status: null,
    mobilid: null,
})
function isOpen(dataID) {
    var data = props.mobil.find(function ({ id }) {
        return id == dataID
    });
    console.log(data);
    StatusForm.status = data.status;
    StatusForm.mobilid = data.id;
    ModalShow.value = true;

}
function isClose() {
    ModalShow.value = false;
}
function submitStatus(){
    StatusForm.put(route('Mobil.StatusUpdate', StatusForm.mobilid),{
        onFinish: ModalShow.value = false
    })
}
</script>

<template>
    <AuthenticatedLayout>

        <Head title="Mobil" />

        <!-- Modal toggle -->
        <Modal v-bind:show="ModalShow" @close="isClose()" :key="mobil.id" :max-width="`md`">
            <div class="relative w-full h-full max-w-md md:h-auto">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <button type="button" @click="ModalShow = false"
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                        data-modal-toggle="authentication-modal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="px-6 py-6 lg:px-8">
                        <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Update Status Mobil
                            {{ StatusForm.mobilid }}</h3>
                        <form class="space-y-6"  @submit.prevent="submitStatus">
                            <div>
                                <InputLabelVue for="email">Your email</InputLabelVue>
                                <select id="countries" v-model="StatusForm.status"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected>Pilih Status</option>
                                    <option value="1">Sewa</option>
                                    <option value="2">Siap</option>
                                    <option value="3">Perbaikan</option>
                                </select>
                            </div>
                            <div>
                                <InputLabelVue>Your password</InputLabelVue>
                                <TextInputVue type="text" name="mobilid" id="mobilid"
                                    v-model:model-value="StatusForm.mobilid" />
                            </div>
                            <button type="submit"
                                class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </Modal>
        <div
            class="w-full rounded-lg bg-gray-200 flex flex-wrap justify-between flex-col-reverse md:flex-row overflow-auto">
            <nav class="flex flex-row">
                <button v-on:click="TabClick(0)" v-bind:class="TabStatus == '0' ? TabActive : TabNonActive">
                    Semua
                </button><button v-on:click="TabClick(1)" v-bind:class="TabStatus == '1' ? TabActive : TabNonActive">
                    Disewa
                </button><button v-on:click="TabClick(2)" v-bind:class="TabStatus == '2' ? TabActive : TabNonActive">
                    Tersedia
                </button><button v-on:click="TabClick(3)" v-bind:class="TabStatus == '3' ? TabActive : TabNonActive">
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
                            <th class="md:px-4 md:py-3 px-2 py-1 border border-gray-200 whitespace-nowrap">Unit Kendaraan</th>
                            <th class="md:px-4 md:py-3 px-2 py-1 border border-gray-200 whitespace-nowrap">No. Polisi</th>
                            <th class="md:px-4 md:py-3 px-2 py-1 border border-gray-200 whitespace-nowrap">Harga</th>
                            <th class="md:px-4 md:py-3 px-2 py-1 border border-gray-200 whitespace-nowrap">Status</th>
                            <th class="md:px-4 md:py-3 px-2 py-1 border border-gray-200 whitespace-nowrap">Detail</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <tr v-for="mobil in mobil" :key="mobil" itemid="1" class="text-gray-700 dark:text-gray-400">
                            <td class="md:px-4 md:py-3 px-2 py-1 border border-gray-200 whitespace-nowrap text-sm">
                                {{ mobil.unit }}
                            </td>
                            <td class="md:px-4 md:py-3 px-2 py-1 border border-gray-200 whitespace-nowrap text-sm">
                                {{ mobil.nopol }}
                            </td>
                            <td class="md:px-4 md:py-3 px-2 py-1 border border-gray-200 whitespace-nowrap text-xs">
                                {{ mobil.harga }}
                            </td>
                            <td class="md:px-4 md:py-3 px-2 py-1 border border-gray-200 whitespace-nowrap text-xs ">
                                <button type="button" @click="isOpen(mobil.id)"
                                    class="px-2 py-1 font-semibold cursor-pointer capitalize leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                    {{ Status(mobil.status) }}
                                </button>

                            </td>
                            <td class="md:px-4 md:py-3 px-2 py-1 border border-gray-200 whitespace-nowrap text-sm">
                                <button class="bg-blue-700 text-white px-2 py-1 rounded-md ml-2 font-semibold">
                                    <Link
                                        :href="route('Mobil.show', [{ id: mobil.id }])" :data="{data:mobil.unit + mobil.nopol}">

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5 font-semibold">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    </Link>
                                </button>
                                <button @click="destroy(mobil.id)"
                                    class="bg-default-red text-white px-2 py-1 rounded-md ml-2 font-semibold">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5 font-semibold">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>

                                </button>
                                <button class=" bg-green-600 text-white px-2 py-1 rounded-md ml-2 font-semibold">
                                    <Link :href="route('Mobil.edit', [{ id: mobil.id }])" :data="{mobil: mobil.unit}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5 font-semibold">
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

    },
    mounted() {
    }
}
</script>
