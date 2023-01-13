<template>
    <AuthenticatedLayout>
        <div class="w-full overflow-hidden rounded-lg shadow-lg">
            <div class="flex items-center max-w-sm py-3 ml-5">
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
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-1.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Search" required>
                </div>
            </div>
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">No.</th>
                            <th class="px-4 py-3">Nik</th>
                            <th class="px-4 py-3">Nama</th>
                            <th class="px-4 py-3">No. HP</th>
                            <th class="px-4 py-3">No. HP Kerabat/Saudara</th>
                            <th class="px-4 py-3">Alamat</th>
                            <th class="px-4 py-3">Tunggakan</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <tr v-for="(user, index) in pengguna.data" :key="user" :index="index"
                            class="text-gray-700 dark:text-gray-400">

                            <td class="px-4 py-3 text-xs border">
                                {{ (pengguna.current_page - 1) * pengguna.per_page + index + 1}}
                            </td>
                            <td class="px-4 py-3 text-xs border">
                                {{ user.nik }}
                            </td>
                            <td class="px-4 py-3 text-xs border">
                                <p class="font-semibold">{{ user.nama }}</p>

                            </td>
                            <td class="px-4 py-3 text-xs border whitespace-nowrap">
                                <span
                                    class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                    {{ user.no_hp }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-xs border whitespace-nowrap">
                                <span
                                    class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                    {{ user.no_hp_lain }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-xs border">
                                {{ user.alamat }}
                            </td>
                            <td class="px-4 py-3 text-xs border">
                                <ul class="space-y-1 max-w-md list-none list-inside text-gray-500 dark:text-gray-400">
                                    <li v-for=" item in user.sewa " :key="item">
                                        <span
                                            v-if="item.status_bayar == '3' || item.status_bayar == '2' || item.status_bayar == '4'"
                                            class="font-semibold text-gray-900 dark:text-white">{{
                                                reduceArray(item.total,1, item.denda)
                                            }}</span>
                                        <span v-else class="font-semibold text-gray-900 dark:text-white">Rp.
                                            ------</span>
                                    </li>
                                </ul>
                                <span>

                                </span>
                            </td>
                            <td class="px-4 py-3 text-xs border ">
                                <div class="flex">
                                    <Link :href="route('Pengguna.show', { id: user.id })">
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
                                    <button class="bg-default-red text-white px-2 py-1 rounded-md ml-2" type="button"
                                        @click="destroy(user.id)" v-if="can.delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <PaginationVue :links="pengguna.links"></PaginationVue>
                <div class="bg-white flex justify-center">
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import PaginationVue from '@/Components/Pagination.vue';
import { useForm, Link } from '@inertiajs/inertia-vue3';
export default {
    name: 'PenggunaVue',
    components: {
        AuthenticatedLayout,
        PaginationVue,
        Link
    },
    setup() {
        const rupiah = (number) => {
            return new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR"
            }).format(number);
        }
        function reduceArray(array = [], lamasewa = 1, denda = 0) {
            var sisa = array.split(',');
            var harga = sisa.reduce((el, b) => Number(el) + Number(b));
            var total = (parseInt(harga) * lamasewa) + parseInt(denda);
            return rupiah(total);
        }
        const deleteForm = useForm();
        function destroy(id) {
            if (confirm("Are you sure you want to Delete")) {
                deleteForm.delete(route("Pengguna.destroy", id));
            }
        }
        return { reduceArray, rupiah, destroy }
    },
    data() {
        return {
            dataUser: {},
            count: 1,
            search: this.filter,
            searchForm: useForm(),
        }
    },
    props: {
        pengguna: {
            type: Object,
            default: () => ({})
        },
        filter: Object.toString(),
        can: Object
    },
    watch: {
        search(value) {
            this.searchForm.get(route('Pengguna.index', { search: value }), { preserveState: true, preserveScroll: true })
        }
    }

}
</script>
