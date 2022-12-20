
<script setup>
import { ref, defineProps, watch } from "vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Modal from "@/Components/Modal.vue";
import InputLabelVue from "@/Components/InputLabel.vue";
import TextInputVue from "@/Components/TextInput.vue";
import PaginationVue from "@/Components/Pagination.vue";

const num = ref(0);
const status = defineProps({
    sewa: {
        type: Object,
        default: () => ({})
    },
    Tab: Object.toString()
});

const deleteForm = useForm();
function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        deleteForm.delete(route("Sewa.destroy", id));
    }
}
// Tab NAV
const TabActive =
    "py-4 px-2 md:px-6 block hover:text-blue-500 focus:outline-none text-blue-500 border-b-2 font-medium border-blue-500";
const TabNonActive =
    "text-gray-600 py-4 px-2 md:px-6 block hover:text-blue-500 focus:outline-none";
const form = useForm();
function TabClick(num) {
    form.get(route("Sewa.index", { status: num }));
}
// END TAB NAV

// Modal
var ModalShow = ref(false);

var StatusForm = useForm({
    status: null,
    sewaid: null
});
function isOpen(dataID) {
    var data = status.sewa.data.find(function ({ id }) {
        return id == dataID;
    });
    StatusForm.status = data.status;
    StatusForm.sewaid = data.id;
    ModalShow.value = true;
}
const falshMessage = ref(false);
function isClose() {
    ModalShow.value = false;
}
function submitStatus() {
    StatusForm.put(route("Sewa.updateStatusModal", StatusForm.sewaid), {
        onFinish: () => {
            ModalShow.value = false;
            falshMessage.value = true;
        }
    });
}
function CloseFlash() {
    falshMessage.value = false;
}
// EndModal

// Cari Sewa

const search = ref("");
const FormSearch = useForm();
watch(search, value => {
    FormSearch.get(route("Sewa.index", { search: value }), {
        preserveState: true,
        replace: false
    });
});

function diffDate(date1) {
    const today = new Date();
    const date = new Date(date1);
    const yyyy = today.getFullYear();
    let mm = today.getMonth() + 1; // Months start at 0!
    let dd = today.getDate();

    if (dd < 10) dd = "0" + dd;
    if (mm < 10) mm = "0" + mm;

    const formattedToday = yyyy + "-" + mm + "-" + dd;

    const day = Math.ceil(Math.abs(date - today) / (1000 * 3600 * 24));
    return day;
}
</script>


<template>
    <AuthenticatedLayout>

        <Head title="Sewa Form" />
        <!-- Modal -->
        <Modal v-bind:show="ModalShow" @close="isClose()" :max-width="`md`">
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
                                clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="px-6 py-6 lg:px-8">
                        <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">
                            Update Status Mobil
                            {{ StatusForm.mobilid }}
                        </h3>
                        <form class="space-y-6" @submit.prevent="submitStatus">
                            <div>
                                <InputLabelVue for="email">Pilih Status Sewa</InputLabelVue>
                                <select id="countries" v-model="StatusForm.status"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="Sewa">Disewa</option>
                                    <option value="Telat">Telat</option>
                                    <option value="Selesai">Selesai</option>
                                </select>
                                <p class="text-xs text-gray-500 text-justify">Keterangan: Pemilihan Status Selesai
                                    Ketika Kendaraan/Unit Yang Disewakan Telah Kembali </p>
                            </div>
                            <div>
                                <TextInputVue type="hidden" name="sewaid" id="sewaid" v-model="StatusForm.sewaid" />
                            </div>
                            <button type="submit"
                                class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </Modal>
        <!-- EndModal -->
        <div class="container bg-gray-200 rounded-t-md">
            <!-- TAB NAV -->
            <div
                class="w-full rounded-lg bg-gray-200 flex flex-wrap justify-between flex-col-reverse md:flex-row overflow-auto">
                <nav class="flex flex-row">
                    <button v-on:click="TabClick('semua')"
                        v-bind:class="Tab == 'semua' ? TabActive : TabNonActive">Semua</button>
                    <button v-on:click="TabClick('Telat')"
                        v-bind:class="Tab == 'Telat' ? TabActive : TabNonActive">Telat</button>
                    <button v-on:click="TabClick('Sewa')"
                        v-bind:class="Tab == 'Sewa' ? TabActive : TabNonActive">Sewa</button>
                </nav>
                <div class="p-3 w-32">
                    <Link :href="route('Sewa.create')"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Tambah</Link>
                </div>
            </div>
            <!-- END TABNAV -->
            <!-- Search -->

            <div class="flex items-center max-w-sm py-3 ml-3">
                <label for="simple-search" class="sr-only">Search</label>
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" id="simple-search" v-model="search"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Search" required />
                </div>
            </div>

            <!-- Endsearch -->

            <!-- Flash Message -->
            <div v-if="falshMessage"
                class="flex flex-row justify-between p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                role="alert">
                <span class="font-medium">Berhasil Diganti!</span>
                <span @click="CloseFlash()" class="cursor-pointer" @mouseover="CloseFlash">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </span>
            </div>

            <!-- TABLE -->
            <div class="w-full overflow-hidden rounded-lg shadow-lg flex flex-col">
                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr
                                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                                <th class="p-1.5 text-xs whitespace-nowrap border">No.</th>
                                <th class="p-1.5 text-xs whitespace-nowrap border">Kode</th>
                                <th class="p-1.5 text-xs whitespace-nowrap border">NIK</th>
                                <th class="p-1.5 text-xs whitespace-nowrap border">Nama Penyewa</th>
                                <th class="p-1.5 text-xs whitespace-nowrap border">No. Polisi</th>
                                <th class="p-1.5 text-xs whitespace-nowrap border">Tanggal Sewa</th>
                                <th class="p-1.5 text-xs whitespace-nowrap border">Tanggal Kembali</th>
                                <th class="p-1.5 text-xs whitespace-nowrap border">Penanggung Jawab</th>
                                <th class="p-1.5 text-xs whitespace-nowrap border">Status</th>
                                <th class="p-1.5 text-xs whitespace-nowrap border">Detail</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            <tr v-for="(mobil, index) in status.sewa.data" :key="mobil" :index="index"
                                class="text-gray-700 dark:text-gray-400">
                                <td class="md:px-4 md:py-3 px-2 py-2 text-sm border">{{ index + 1 }}</td>
                                <td class="md:px-4 md:py-3 px-2 py-2 text-sm border">{{ mobil.kode }}</td>
                                <td class="md:px-4 md:py-3 px-2 py-2 text-sm border">{{ mobil.nik }}</td>
                                <td class="md:px-4 md:py-3 px-2 py-2 text-sm border">{{ mobil.pengguna.nama }}</td>
                                <td class="md:px-4 md:py-3 px-2 py-2 text-sm border">{{ mobil.nopol }}</td>
                                <td class="md:px-4 md:py-3 px-2 py-2 text-sm border">{{ mobil.waktusewa.tgl_sewa }}</td>
                                <td class="md:px-4 md:py-3 px-2 py-2 text-sm border">
                                    {{ mobil.waktusewa.tgl_kembali }}
                                    <br />
                                    <span class="text-xs text-red-500">{{ diffDate(mobil.waktusewa.tgl_kembali) }} Hari
                                        lagi</span>
                                </td>
                                <td class="md:px-4 md:py-3 px-2 py-2 text-sm border">{{ mobil.user.name }}</td>
                                <td class="md:px-4 md:py-3 px-2 py-2 text-xs border">
                                    <span @click="isOpen(mobil.id)"
                                        class="px-2 py-1 font-semibold cursor-pointer leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">{{
                                                mobil.status
                                        }}</span>
                                </td>
                                <td class="md:px-4 md:py-3 px-2 py-2 text-sm flex">
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
                                    <button class="bg-default-red text-white px-2 py-1 rounded-md ml-2"
                                        @click="destroy(mobil.id)">
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
                <PaginationVue :links="status.sewa.data" class="mt-3 text-black"></PaginationVue>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

export default {
    name: "MobilVue",
    components: {
        AuthenticatedLayout
    },
    data() {
        return {
            TabActive: "",
            TabNonActive: "",
            txt: "",
            unit: "",
            nopol: "",
            fotodepan: "",
            fotobelakang: "",
            fotokiri: "",
            fotokanan: "",
            status: ""
        };
    },
    beforeMount() { },
    methods: {
        Status(n) {
            var msg = "";
            switch (n) {
                case 0:
                    msg = "Sewa";
                    break;
                case 1:
                    msg = "Telat";
                    break;
                case 5:
                    msg = "Selesai";
                    break;
                default:
                    msg = "semua";
                    break;
            }
            return msg;
        }
    }
};
</script>
