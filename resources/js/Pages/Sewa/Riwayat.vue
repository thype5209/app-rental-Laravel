
<script setup>
import { ref, defineProps, watch } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import PaginationVue from '@/Components/Pagination.vue';

const status = defineProps({
    sewa: {
        type: Object,
        default: () => ({})
    },
    can: Object,
})

const deleteForm = useForm();
function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        deleteForm.delete(route('Sewa.destroy', id));
    }
}

// Cari Sewa

const search = ref('');
const FormSearch = useForm();
watch(search, (value) => {
    FormSearch.get(route('Sewa.riwayat', { search: value }), {
        preserveState: true,
    })
});

</script>


<template>
    <AuthenticatedLayout>

        <Head title="Sewa Riwayat" />
        <!-- Modal -->

        <!-- Search -->

        <div class="flex items-center max-w-sm py-3">
            <label for="simple-search" class="sr-only">Search</label>
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input type="text" id="simple-search" v-model="search"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-1.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Search" required>
            </div>
        </div>

        <!-- Endsearch -->
        <!-- TABLE -->
        <div class="w-full overflow-hidden rounded-lg shadow-lg flex flex-col">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b  bg-gray-50">
                            <th class="md:px-4 md:py-3 px-2 py-1 text-xs whitespace-nowrap border">No.</th>
                            <th class="md:px-4 md:py-3 px-2 py-1 text-xs whitespace-nowrap border">Kode</th>
                            <th class="md:px-4 md:py-3 px-2 py-1 text-xs whitespace-nowrap border">NIK</th>
                            <th class="md:px-4 md:py-3 px-2 py-1 text-xs whitespace-nowrap border">Nama Penyewa</th>
                            <th class="md:px-4 md:py-3 px-2 py-1 text-xs whitespace-nowrap border">No. Polisi</th>
                            <th class="md:px-4 md:py-3 px-2 py-1 text-xs whitespace-nowrap border">Tanggal Sewa</th>
                            <th class="md:px-4 md:py-3 px-2 py-1 text-xs whitespace-nowrap border">Tanggal Kembali</th>
                            <th class="md:px-4 md:py-3 px-2 py-1 text-xs whitespace-nowrap border">Status</th>
                            <th class="md:px-4 md:py-3 px-2 py-1 text-xs whitespace-nowrap border">Detail</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <tr v-for="(mobil, index) in status.sewa.data" :key="mobil" :index="index"
                            class="text-gray-700 dark:text-gray-400">
                            <td class="md:px-4 md:py-3 p-1.5 border text-xs md:text-sm">
                                {{ index + 1 }}
                            </td>
                            <td class="md:px-4 md:py-3 p-1.5 border text-xs md:text-sm">
                                {{ mobil.kode }}
                            </td>
                            <td class="md:px-4 md:py-3 p-1.5 border text-xs md:text-sm">
                                <span v-if="mobil.nik !=null">{{ mobil.nik }}</span>
                                <span v-else>Kunci</span>
                            </td>
                            <td class="md:px-4 md:py-3 p-1.5 border text-xs md:text-sm">
                                <span v-if="mobil.pengguna != null">{{ mobil.pengguna.nama }}</span>
                                <span v-else-if="mobil.sopir_id != null">sopir</span>
                                <span v-else>Data Penyewa Terhapus</span>
                            </td>
                            <td class="md:px-4 md:py-3 p-1.5 border text-xs md:text-sm">
                                {{ mobil.nopol }}
                            </td>
                            <td class="md:px-4 md:py-3 p-1.5 border text-xs md:text-sm">
                                {{ mobil.waktusewa.tgl_sewa }}
                            </td>
                            <td class="md:px-4 md:py-3 p-1.5 border text-xs md:text-sm">
                                {{ mobil.waktusewa.tgl_kembali }}
                            </td>
                            <td class="md:px-4 md:py-3 px-2 py-2 text-xs">
                                <span
                                    class="px-2 py-1 font-semibold cursor-pointer leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                    {{ mobil.status }}
                                </span>
                            </td>
                            <td class="md:px-4 md:py-3 p-1.5 border text-xs md:text-sm flex">
                                <Link :href="route('Sewa.show', { id: mobil.id })">
                                <button class="  bg-blue-500 text-white md:px-2 md:py-1 p-1 rounded-md ml-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="sm:w-6 sm:h-6 h-4 w-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                                </Link>
                                <button class="bg-default-red text-white md:px-2 md:py-1 p-1 rounded-md ml-2" v-if="can.delete"
                                    @click="destroy(mobil.id)">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="sm:w-6 sm:h-6 h-4 w-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>

                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <PaginationVue :links="status.sewa.links" class="mt-3 text-black"></PaginationVue>
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

    },
    methods: {

        Status(n) {
            var msg = '';
            switch (n) {
                case 0:
                    msg = 'Sewa'
                    break;
                case 1:
                    msg = 'Telat'
                    break;
                case 5:
                    msg = 'Selesai'
                    break;
                default:
                    msg = 'semua'
                    break;
            }
            return msg;
        }

    },
}
</script>
