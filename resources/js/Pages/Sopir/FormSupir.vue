<script setup>
import { Link, useForm, Head } from '@inertiajs/inertia-vue3';
import { defineProps, ref } from 'vue';
import AuthenticatedLayoutVue from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButtonVue from '@/Components/PrimaryButton.vue';
import TextInputVue from '@/Components/TextInput.vue';
import InputLabelVue from '@/Components/InputLabel.vue';
import ModalVue from '@/Components/Modal.vue';
import InputErrorVue from '@/Components/InputError.vue';
const data = defineProps({
    sopir: Object,
})

const SopirForm = useForm({
    nama: data.sopir == null ? '' : data.sopir.nama,
    nik: data.sopir == null ? '' : data.sopir.nik,
    no_hp: data.sopir == null ? '' : data.sopir.no_hp,
    alamat: data.sopir == null ? '' : data.sopir.alamat,
})

function submit() {
    if (data.sopir == null) {
        SopirForm.post(route('Sopir.store'), {
            preserveState: true,
            onSuccess: () => {
                SopirForm.reset();
            },
        })
    }else{
        SopirForm.put(route('Sopir.update', {id: data.sopir.id}), {
            preserveState: true,
            onSuccess: () => {
                SopirForm.reset();
            },
        })
    }
}
</script>

<template>
    <AuthenticatedLayoutVue>

        <Head title="Form Supir" />
        <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
            <ModalVue :show="true">
                <form @submit.prevent="submit">
                    <div class="flex flex-col -mb-8  p-8">
                        <div class="flex flex-col justify-center">
                            <InputLabelVue>Nama</InputLabelVue>
                            <TextInputVue v-model="SopirForm.nama" placeholder="Name" />
                            <InputErrorVue :message="SopirForm.errors.nama" />
                        </div>
                        <div class="flex flex-col justify-center">
                            <InputLabelVue>NIK</InputLabelVue>
                            <TextInputVue v-model="SopirForm.nik" placeholder="NIK" />
                            <InputErrorVue :message="SopirForm.errors.nik" />
                        </div>
                        <div class="flex flex-col justify-center">
                            <InputLabelVue>Nomor Hp</InputLabelVue>
                            <TextInputVue v-model="SopirForm.no_hp" placeholder="No Hp" />
                            <InputErrorVue :message="SopirForm.errors.no_hp" />
                        </div>
                        <div class="flex flex-col justify-center">
                            <InputLabelVue>Alamat</InputLabelVue>
                            <TextInputVue v-model="SopirForm.alamat" placeholder="Alamat" />
                            <InputErrorVue :message="SopirForm.errors.alamat" />
                        </div>
                    </div>
                    <div class="flex items-center justify-between px-8 py-4 bg-gray-50 border-t border-gray-100">
                        <Link :href="route('Sopir.index')">
                        <PrimaryButtonVue class="bg-red-500" type="submit">Kembali</PrimaryButtonVue>
                        </Link>
                        <PrimaryButtonVue class="btn-indigo" type="submit">Simpan</PrimaryButtonVue>
                    </div>
                </form>
            </ModalVue>
        </div>
    </AuthenticatedLayoutVue>
</template>
