<script setup>
import { Link, useForm,Head } from '@inertiajs/inertia-vue3';
import { defineProps, ref } from 'vue';
import AuthenticatedLayoutVue from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButtonVue from '@/Components/PrimaryButton.vue';
import TextInputVue from '@/Components/TextInput.vue';

const data = defineProps({
    sopir: Object,
})

const SopirForm = useForm({
    nama: data.sopir == null ? '': data.sopir.nama,
    nik: data.sopir == null ? '': data.sopir.nik,
    no_hp: data.sopir == null ? '': data.sopir.no_hp,
    alamt: data.sopir == null ? '': data.sopir.alamt,
})

function submit(){
    SopirForm.post(route('Sopir.store'),{
        onSuccess: SopirForm.reset(),
    })
}
</script>

<template>
    <AuthenticatedLayoutVue>
        <Head title="Form Supir"/>
        <h1 class="mb-8 text-3xl font-bold">
            <Link class="text-indigo-400 hover:text-indigo-600" href="/organizations">Organizations</Link>
            <span class="text-indigo-400 font-medium">/</span> Create
          </h1>
          <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
            <form @submit.prevent="store">
              <div class="flex flex-wrap -mb-8 -mr-6 p-8">
                <TextInputVue v-model="form.name" :error="form.errors.name" class="pb-8 pr-6 w-full lg:w-1/2" label="Name" />
                <TextInputVue v-model="form.nik" :error="form.errors.nik" class="pb-8 pr-6 w-full lg:w-1/2" label="nik" />
                <TextInputVue v-model="form.no_hp" :error="form.errors.no_hp" class="pb-8 pr-6 w-full lg:w-1/2" label="no_hp" />
                <TextInputVue v-model="form.alamat" :error="form.errors.alamat" class="pb-8 pr-6 w-full lg:w-1/2" label="Address" />
              </div>
              <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
                <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create Organization</loading-button>
              </div>
            </form>
          </div>
    </AuthenticatedLayoutVue>
</template>
