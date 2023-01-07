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
                            <th class="px-4 py-3">Alamat</th>
                            <th class="px-4 py-3">Tunggakan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <tr v-for="(user, index) in pengguna.data" :key="user" :index="index"
                            class="text-gray-700 dark:text-gray-400">

                            <td class="px-4 py-3 text-xs">
                                {{ (pengguna.current_page -1)* pengguna.per_page + index + 1}}
                            </td>
                            <td class="px-4 py-3 text-xs">
                                {{ user.nik }}
                            </td>
                            <td class="px-4 py-3 text-xs">
                                <p class="font-semibold">{{ user.nama }}</p>

                            </td>
                            <td class="px-4 py-3 text-xs whitespace-nowrap">
                                <span
                                    class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                    {{ user.no_hp }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-xs">
                                {{ user.alamat }}
                            </td>
                            <td class="px-4 py-3 text-xs">
                                <ul class="space-y-1 max-w-md list-none list-inside text-gray-500 dark:text-gray-400">
                                    <li v-for=" item in user.sewa " :key="item">
                                        <span v-if="item.status_bayar == '3' || item.status_bayar == '2' || item.status_bayar == '4'" class="font-semibold text-gray-900 dark:text-white">Rp. {{ reduceArray(item.harga, item.waktusewa.lama_sewa, item.denda) }}</span>
                                        <span v-else class="font-semibold text-gray-900 dark:text-white">Rp. ------</span>
                                    </li>
                                </ul>
                                <span>

                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <PaginationVue :links="pengguna.links"></PaginationVue>
                <div
                class="bg-white flex justify-center">
            </div>
        </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import PaginationVue from '@/Components/Pagination.vue';
import { useForm } from '@inertiajs/inertia-vue3';
export default {
    name: 'PenggunaVue',
    components: {
        AuthenticatedLayout,
        PaginationVue
    },
    setup(){
        function reduceArray(array = [], lamasewa = 1, denda = 0) {
            var sisa = array.split(',');
            var harga = sisa.reduce((el, b) => el + b);
            var total = (parseInt(harga) * lamasewa) + parseInt(denda);
            return Number(total).toLocaleString();
        }
        return {reduceArray}
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
        filter: Object.toString()
    },
    watch: {
        search(value) {
            this.searchForm.get(route('Pengguna.index', { search: value }), { preserveState: true, preserveScroll: true })
        }
    }

}
</script>
