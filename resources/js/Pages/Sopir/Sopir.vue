<template>
    <AuthenticatedLayout>

        <Head title="Sopir" />
        <div class="w-full overflow-hidden rounded-lg shadow-lg">
            <div class="p-3 w-32">
                <Link :href="route('Sopir.create')" preserve-state
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Tambah</Link>
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
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <tr v-for="(user, index) in sopir.data" :key="user" :index="index"
                            class="text-gray-700 dark:text-gray-400">

                            <td class="px-4 py-3 text-sm">
                                {{ count + index }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ user.nik }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center text-sm">
                                    <!-- Avatar with inset shadow -->
                                    <div>
                                        <p class="font-semibold">{{ user.nama }}</p>

                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-xs">
                                <span
                                    class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                    {{ user.no_hp }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ user.alamat }}
                            </td>
                            <td class="md:px-4 md:py-3 px-2 py-1 border border-gray-200 whitespace-nowrap text-sm">
                                <button class="bg-blue-700 text-white px-2 py-1 rounded-md ml-2 font-semibold">
                                    <Link :href="route('Sopir.show', [{ id: user.id }])"
                                        :data="{ data: user.nama + user.nik }">

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5 font-semibold">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    </Link>
                                </button>
                                <button @click="destroy(user.id)"
                                    class="bg-default-red text-white px-2 py-1 rounded-md ml-2 font-semibold">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5 font-semibold">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>

                                </button>
                                <button class=" bg-green-600 text-white px-2 py-1 rounded-md ml-2 font-semibold">
                                    <Link :href="route('Sopir.edit', [{ id: user.id }])"
                                        :data="{ id: user.unit }">
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
                class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                <PaginationVue :links="sopir.data"></PaginationVue>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link, Head, useForm } from '@inertiajs/inertia-vue3';
import { ref, watch } from 'vue';
import PaginationVue from '@/Components/Pagination.vue';
import axios from 'axios';
export default {
    name: 'PenggunaVue',
    components: {
        AuthenticatedLayout,
        ref,
        watch,
        Link,
        Head,
        useForm,
        PaginationVue,
    },
    data() {
        return {
            dataUser: {},
            count: 1,
            destroyForm: useForm()
        }
    },
    mounted() {
    },
    props: {
        sopir: {
            type: Object,
            default: () => ({})
        }
    },
    methods: {
        destroy(id){
            if(confirm("Apakah Anda Yakin??")){
                this.destroyForm.delete(route('Sopir.destroy', {id: id}), {
                    preserveState: true,
                })
            }
        }
    },
}
</script>
