
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link, Head, useForm } from '@inertiajs/inertia-vue3';
import { ref, watch, defineProps } from 'vue';
import PaginationVue from '@/Components/Pagination.vue';

const props = defineProps({
    sopir: {
        type: Object,
        default: () => ({})
    },
    filter: Object.toString(),
    can:{
        type:Object,
        default: ()=>({})
    }
})
const dataUser = ref({});
const count = ref(1);
const search = ref('');
const SearchForm = useForm();
const destroyForm = useForm();
function destroy(id) {
    if (confirm("Apakah Anda Yakin??")) {
        destroyForm.delete(route('Sopir.destroy', { id: id }), {
            preserveState: true,
        })
    }
}

watch(search, function(value){
    SearchForm.get(route('Sopir.index', {search:value}), {preserveState: true})
})

</script>
<template>
    <AuthenticatedLayout>

        <Head title="Sopir" />
        <div class="w-full overflow-hidden rounded-lg shadow-lg">
            <div class="flex flex-1 justify-between flex-row-reverse">
                <div class="p-3 w-32">
                    <Link :href="route('Sopir.create')" preserve-state  v-if="can.create"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Tambah</Link>
                </div>
                <div class="flex items-center max-w-lg py-3 ml-5">
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
            </div>
            <!-- Flash Message -->
            <div v-if="$page.props.flash.success"
                class=" flex flex-row justify-between p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                role="alert">
                <span class="font-medium">{{ $page.props.flash.success }}</span>

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
                            <th class="px-4 py-3"  v-if="can.edit || can.delete">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <tr v-for="(user, index) in sopir.data" :key="user" :index="index"
                            class="text-gray-700 dark:text-gray-400">

                            <td class="px-4 py-3 text-xs">
                                {{ count + index }}
                            </td>
                            <td class="px-4 py-3 text-xs">
                                {{ user.nik }}
                            </td>
                            <td class="px-4 py-3 text-xs">
                                <p class="font-semibold">{{ user.nama }}</p>

                            </td>
                            <td class="px-4 py-3 text-xs">
                                <span
                                    class="px-2 py-1 whitespace-nowrap font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                    {{ user.no_hp }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-xs">
                                {{ user.alamat }}
                            </td>
                            <td class="md:px-4 md:py-3 px-2 py-1 border border-gray-200 whitespace-nowrap text-xs" v-if="can.edit || can.delete">

                                <button @click="destroy(user.id)" v-if="can.delete"
                                    class="bg-default-red text-white px-2 py-1 rounded-md ml-2 font-semibold">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5 font-semibold">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>

                                </button>
                                <button class=" bg-green-600 text-white px-2 py-1 rounded-md ml-2 font-semibold" v-if="can.edit">
                                    <Link :href="route('Sopir.edit', [{ id: user.id }])" :data="{ id: user.unit }">
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
            <div
                class=" px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                <PaginationVue :links="sopir.links"></PaginationVue>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

