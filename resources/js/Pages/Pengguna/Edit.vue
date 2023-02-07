<script setup>
import { Link, Head, useForm } from '@inertiajs/inertia-vue3';
import { defineProps } from 'vue';
import AuthenticatedLayoutVue from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButtonVue from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
const data = defineProps({
    pengguna: Object,
})

const Form = useForm({
    no_hp_lain: data.pengguna.no_hp_lain,
    nama: data.pengguna.nama,
    nik: data.pengguna.nik,
    no_hp: data.pengguna.no_hp,
    alamat: data.pengguna.alamat,
    pekerjaan: data.pengguna.pekerjaan,
    tempat_lahir: data.pengguna.tempat_lahir,
    tgl_lahir: data.pengguna.tgl_lahir,
    foto_ktp: data.pengguna.foto_ktp,
})
function submit() {
    Form.post(route('Pengguna.update', data.pengguna.id), {
        forceFormData: true,

    })
}

</script>

<template>
    <AuthenticatedLayoutVue>

        <Head title="Form Supir" />
        <div class="w-full bg-white rounded-md shadow overflow-hidden">
            <form @submit.prevent="submit" class="w-full px-5 md:px-10" method="POST" enctype="multipart/form-data">
                <div class="-mx-3 md:flex flex-col mb-6">
                    <div class="w-full px-3 relative pt-5">
                        <InputLabel
                            class="block text-black uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                            for="grid-first-name">Foto KTP Penyewa </InputLabel>
                        <input type="file" name="file" id="file" @change="Form.foto_ktp = $event.target.files[0]" />
                        <p class="text-red text-xs italic text-gray-500">Ket: Kosongkan Jika Tidak Ingin Di Ganti
                        </p>
                        <p class="text-red text-xs italic text-gray-500">{{ Form.errors.foto_ktp }}
                        </p>
                        <progress v-if="Form.progress" :value="Form.progress.percentage" max="100">
                            {{ Form.progress.percentage }}%
                        </progress>
                    </div>
                </div>
                <div class="-mx-3 md:flex mb-6">

                    <div class="md:w-1/2 px-3 mb-4 md:mb-0">
                        <InputLabel
                            class="block text-black uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                            for="grid-first-name">NIK</InputLabel>
                        <TextInput id="grid-first-name" type="text" placeholder="NIK" v-model="Form.nik" />
                        <p v-if="Form.errors.nik" class="text-red text-xs italic text-red-500">Mohon Di Isi
                        </p>
                    </div>
                    <div class="md:w-1/2 px-3">
                        <InputLabel
                            class="block text-black uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                            for="grid-last-name">Nama</InputLabel>
                        <TextInput id="grid-last-name" type="text" placeholder="Nama Lengkap" v-model="Form.nama" />
                        <p v-if="Form.errors.nama" class="text-red text-xs italic text-red-500">Mohon Di Isi
                        </p>
                    </div>
                </div>
                <div class="-mx-3 md:flex mb-6">
                    <div class="md:w-1/2 px-3 mb-4 md:mb-0">
                        <InputLabel
                            class="block text-black uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                            for="grid-first-name">Tempat/Tanggal Lahir</InputLabel>
                        <div class="flex">
                            <TextInput id="grid-last-name" class="1/2" type="text" placeholder="Tempat Lahir"
                                v-model="Form.tempat_lahir" />
                            <TextInput id="grid-last-name" class="1/2" type="date" placeholder="Doe"
                                v-model="Form.tgl_lahir" />
                        </div>
                        <p v-if="Form.errors.tempat_lahir" class="text-red text-xs italic text-red-500">
                            Mohon Di Isi</p>
                    </div>
                    <div class="md:w-1/2 px-3">
                        <InputLabel
                            class="block text-black uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                            for="grid-last-name">Alamat</InputLabel>

                        <TextInput id="grid-first-name" type="text" placeholder="Jane" v-model="Form.alamat" />
                        <p v-if="Form.errors.tgl_lahir" class="text-red text-xs italic text-red-500">Mohon
                            Di Isi</p>
                    </div>
                    <div class="md:w-1/2 px-3">
                        <InputLabel
                            class="block text-black uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                            for="grid-last-name">Pekerjaan</InputLabel>

                        <TextInput id="grid-first-name" type="text" placeholder="Jane" v-model="Form.pekerjaan" />
                        <p v-if="Form.errors.pekerjaan" class="text-red text-xs italic text-red-500">Mohon
                            Di Isi</p>
                    </div>
                </div>
                <div class="-mx-3 md:flex mb-6">
                    <div class="md:w-1/2 px-3 mb-4 md:mb-0">
                        <InputLabel
                            class="block text-black uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                            for="grid-first-name">Nomor HP</InputLabel>
                        <TextInput id="grid-first-name" type="text" placeholder="+62" v-model="Form.no_hp" />
                        <p v-if="Form.errors.no_hp" class="text-red text-xs italic text-red-500">{{ Form.errors.no_hp }}
                        </p>
                    </div>
                    <div class="md:w-1/2 px-3 mb-4">
                        <InputLabel
                            class="block text-black uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                            for="grid-last-name">Nomor HP Kerabat lain</InputLabel>
                        <TextInput id="grid-last-name" type="text" placeholder="+62" v-model="Form.no_hp_lain" />
                        <p v-if="Form.errors.no_hp_lain" class="text-red text-xs italic text-red-500">Mohon
                            Di Isi</p>
                    </div>
                </div>
                <div class="flex items-center justify-between px-8 py-4 bg-gray-50 border-t border-gray-100">
                    <Link :href="route('Pengguna.index')">
                    <PrimaryButtonVue class="bg-red-500" type="submit">Kembali</PrimaryButtonVue>
                    </Link>
                    <PrimaryButtonVue class="btn-indigo" type="submit">Simpan</PrimaryButtonVue>
                </div>
            </form>
        </div>
    </AuthenticatedLayoutVue>
</template>
