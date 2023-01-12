<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,Link } from '@inertiajs/inertia-vue3';
const props = defineProps({
  user: {
    type: Object,
    default: () => ({}),
  },
  can: {
    type: Object,
    default: () => ({}),
  },
})
</script>
<template>
    <Head title="users" />
    <AuthenticatedLayout>
        <div class="py-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex bg-gray-800 justify-between items=center p-5">
                        <div class="flex space-x-2 items-center text-white" v-if="$page.props.flash.success">
                            {{ $page.props.flash.success }}
                        </div>
                        <div class="flex space-x-2 items-center text-white" v-if="$page.props.flash.error">
                            {{ $page.props.flash.error }}
                        </div>
                        <div class="flex space-x-2 items-center" v-if="can.create">
                            <Link :href="route('User.create')"  class="px-4 py-2 cursor-pointer bg-default-blue uppercase text-white rounded focus:outline-none flex items-center"><span class="iconify mr-1" data-icon="gridicons:create" data-inline="false"></span> Tambah Pengguna</Link>
                        </div>
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 px-6">Name</th>
                                <th scope="col" class="py-3 px-6">email</th>
                                <th scope="col" class="py-3 px-6">role</th>
                                <th v-if="can.edit || can.delete" scope="col" class="py-3 px-6">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="users in user.data" :key="users.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td data-label="Name" class="py-4 px-6">
                                    {{ users.name }}
                                </td>
                                <td data-label="Name" class="py-4 px-6">
                                    {{ users.email }}
                                </td>
                                <td data-label="Name" class="py-4 px-6">
                                    <span v-for="role in users.roles">
                                        {{ role.name }}
                                    </span>
                                </td>
                                <td
                                    v-if="can.edit || can.delete"
                                    class="py-4 px-6"
                                >
                                    <div type="justify-start lg:justify-end" no-wrap>
                                        <Link :href="route('User.edit', {id: users.id})"  :data="{formCEK: false}">
                                            <PrimaryButton class="ml-4 bg-default-blue px-2 py-1 rounded text-white cursor-pointer" v-if="can.edit">
                                                Edit
                                            </PrimaryButton>
                                        </Link>
                                        <Link :href="route('User.destroy', {id: users.id})">
                                            <PrimaryButton class="ml-4 bg-red-500 px-2 py-1 rounded text-white cursor-pointer" v-if="can.delete">
                                                Delete
                                            </PrimaryButton>
                                        </Link>
                                        <Link :href="route('User.edit', {id: users.id})" :data="{formCEK: true}">
                                            <PrimaryButton class="ml-4 bg-red-500 px-2 py-1 rounded text-white cursor-pointer" v-if="can.delete">
                                                Ganti Sandi
                                            </PrimaryButton>
                                        </Link>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
