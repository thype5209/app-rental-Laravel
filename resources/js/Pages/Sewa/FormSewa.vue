<script setup>
import { Link, Head, useForm } from '@inertiajs/inertia-vue3';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue'
import SelectVUe from '@/Components/Select.vue';
import PrimaryButtonVue from '@/Components/PrimaryButton.vue';
import { defineProps, ref, watch, onBeforeMount, onMounted } from 'vue';

const props = defineProps({
    pengguna: {
        type: Object,
        default: () => ({})
    },
    mobil: {
        type: Object,
        default: () => ({})
    },
})

const Form = useForm({
    nik: '019020101',
    nama: 'AGustiawan',
    tempat_lahir: 'Bulukumba',
    tgl_lahir: '1999-10-17',
    alamat: 'Makassar',
    no_hp: '02090910',
    no_hp_lain: '920201092',
    sosial: 'FB',
    mobil_id: '',
    unit: '',
    nopol: '',
    tahun: '',
    nilaisewahari: '',
    nilaisewabulan: '',
    tgl_sewa: '',
    tgl_kembali: '',
    lama_sewa: '31',
    tujuan: 'Pinjam',
    jaminan: 'KTP',
})
var TabActive = 'bg-default-red py-2 md:px-6 block hover:text-default-red focus:outline-none text-white border-b-2 font-medium border-default-dark'
var TabNonActive = 'text-gray-600 py-2 md:px-6 block hover:text-blue-500 focus:outline-none';
let TabStatus = ref(0);

function GetMobil(event) {
    axios.get('/Mobil/GetIDMobil/' + event.target.value)
        .then(function (response) {
            console.log(response.data)
            const mobil = response.data;
            Form.unit = mobil.unit;
            Form.nopol = mobil.nopol;
            Form.tahun = mobil.tahun;
            Form.nilaisewahari = Number(mobil.harga).toLocaleString();
            Form.nilaisewabulan = Number(mobil.harga * 30).toLocaleString();
            Form.mobil_id = mobil.id;

        }).catch(errors => console.log(errors))
}

// Kirim Data
function submit() {
    Form.get(route('Sewa.formulir'))
}

</script>

<template>
    <AuthenticatedLayoutVue>

        <Head title="Sewa Form" />
        <!-- component -->
        <form class="w-full" @submit.prevent="submit">

            <div class="bg-gray-200 shadow-md rounded px-8 pt-6 mb-4 flex flex-col my-2">
                <nav class="flex justify-center gap-4">
                    <PrimaryButtonVue @click="TabStatus = '0'"
                        v-bind:class="TabStatus == '0' ? TabActive : TabNonActive">
                        Kunci
                    </PrimaryButtonVue>
                    <PrimaryButtonVue @click="TabStatus = '1'"
                        v-bind:class="TabStatus == '1' ? TabActive : TabNonActive">
                        Lepas Kunci
                    </PrimaryButtonVue>
                </nav>
                <div class="-mx-3 md:flex mb-6" v-if="TabStatus == '0'">
                    <div class="md:w-1/2 px-3 mb-4 md:mb-0">
                        <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                            for="grid-first-name">
                            NIK
                        </InputLabel>
                        <TextInput id="grid-first-name" type="text" placeholder="Jane" />
                        <p v-if="Form.errors.nik" class="text-red text-xs italic text-red-500">Please fill out this
                            field.
                        </p>
                    </div>
                    <div class="md:w-1/2 px-3">
                        <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                            for="grid-last-name">
                            Nama
                        </InputLabel>
                        <TextInput id="grid-last-name" type="text" placeholder="Nama Lengkap" />
                        <p v-if="Form.errors.nama" class="text-red text-xs italic text-red-500">Please fill out this
                            field.
                        </p>
                    </div>

                </div>
                <div class="-mx-3 md:flex mb-6" v-if="TabStatus == '0'">
                    <div class="md:w-1/2 px-3 mb-4 md:mb-0">
                        <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                            for="grid-first-name">
                            Tempat/Tanggal Lahir
                        </InputLabel>
                        <div class="flex">
                            <TextInput id="grid-last-name" class="1/2" type="text" placeholder="Tempat Lahir" />
                            <TextInput id="grid-last-name" class="1/2" type="date" placeholder="Doe" />
                        </div>
                        <p v-if="Form.errors.tempat_lahir" class="text-red text-xs italic text-red-500">Please fill out
                            this
                            field.</p>
                    </div>
                    <div class="md:w-1/2 px-3">
                        <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                            for="grid-last-name">
                            Alamat
                        </InputLabel>

                        <TextInput id="grid-first-name" type="text" placeholder="Jane" />
                        <p v-if="Form.errors.tgl_lahir" class="text-red text-xs italic text-red-500">Please fill out
                            this
                            field.</p>
                    </div>
                </div>
                <div class="-mx-3 md:flex mb-6" v-if="TabStatus == '0'">
                    <div class="md:w-1/2 px-3 mb-4 md:mb-0">
                        <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                            for="grid-first-name">
                            Nomor HP
                        </InputLabel>
                        <TextInput id="grid-first-name" type="tel" placeholder="+62" />
                        <p v-if="Form.errors.no_hp" class="text-red text-xs italic text-red-500">Please fill out this
                            field.
                        </p>
                    </div>
                    <div class="md:w-1/2 px-3 mb-4">
                        <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                            for="grid-last-name">
                            Nomor HP Kerabat lain
                        </InputLabel>
                        <TextInput id="grid-last-name" type="tel" placeholder="+62" />
                        <p v-if="Form.errors.no_hp_lain" class="text-red text-xs italic text-red-500">Please fill out
                            this
                            field.</p>
                    </div>
                    <div class="md:w-1/2 px-3 mb-4">
                        <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                            for="grid-last-name">
                            Sosial
                        </InputLabel>
                        <TextInput id="grid-last-name" type="tel" placeholder="+62" />
                    </div>
                </div>
                <div class="-mx-3 md:flex mb-6" v-if="TabStatus == '1'">
                    <div class="w-full px-3  ">
                        <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                            for="grid-first-name">
                            Nama Supir
                        </InputLabel>
                        <SelectVUe class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                            id="mobil_id" for="grid-first-name" @change="GetMobil($event)">
                            <option v-for="mobil in props.mobil" :key="mobil.id" :value="mobil.id">
                                Unit= {{ mobil.unit }} | Nopol= {{ mobil.nopol }} | Tahun= {{ mobil.tahun }}
                            </option>
                        </SelectVUe>
                        <p v-if="Form.errors.mobil_id" class="text-red text-xs italic text-red-500">Please fill out this
                            field.</p>
                    </div>
                </div>
            </div>

            <div class="inline-flex justify-center items-center w-full">
                <hr class="my-1 w-full h-1 bg-gray-200 rounded border-0 dark:bg-gray-700">
                <div class="absolute left-1/2 px-4 bg-white -translate-x-1/2 dark:bg-gray-900">
                    Detail Mobil
                </div>
            </div>
            <div class="bg-gray-200 shadow-md rounded px-8 pt-6 mb-4 flex flex-col my-2">
                <div class="-mx-3 md:flex mb-6">
                    <div class="w-full px-3  ">
                        <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                            for="grid-first-name">
                            Jenis Mobil
                        </InputLabel>
                        <SelectVUe class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                            id="mobil_id" for="grid-first-name" @change="GetMobil($event)">
                            <option value="">---</option>
                            <option v-for="mobil in props.mobil" :key="mobil.id" :value="mobil.id">
                                Unit= {{ mobil.unit }} | Nopol= {{ mobil.nopol }} | Tahun= {{ mobil.tahun }}
                            </option>
                        </SelectVUe>
                        <p v-if="Form.errors.mobil_id" class="text-red text-xs italic text-red-500">Please fill out this
                            field.</p>
                    </div>
                </div>
                <div class="-mx-3 sm:flex mb-6">
                    <div class="sm:w-1/3 px-3">
                        <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                            for="grid-last-name">
                            Jenis Kendaraan
                        </InputLabel>
                        <TextInput id="grid-last-name" type="text" placeholder="Jenis Kendaraan" readonly required
                            v-model="Form.unit" />
                        <p v-if="Form.errors.unit" class="text-red text-xs italic text-red-500">Please fill out this
                            field.
                        </p>
                    </div>
                    <div class="sm:w-1/3 px-3 ">
                        <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                            for="grid-first-name">
                            No. Kendaraan
                        </InputLabel>
                        <TextInput id="grid-last-name" class="1/2" type="text" placeholder="No. Kendaraan" readonly
                            required v-model="Form.nopol" />
                        <p v-if="Form.errors.nopol" class="text-red text-xs italic text-red-500">Please fill out this
                            field.
                        </p>
                    </div>
                    <div class="sm:w-1/2 px-3">
                        <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                            for="grid-last-name">
                            Tahun
                        </InputLabel>

                        <TextInput id="grid-first-name" type="number" placeholder="0000" readonly required
                            v-model="Form.tahun" />
                        <p v-if="Form.errors.tahun" class="text-red text-xs italic text-red-500">Please fill out this
                            field.
                        </p>
                    </div>
                </div>
                <div class="-mx-3 sm:flex justify-center w-full">
                    <div class="md:w-1/2 px-3 mb-4 md:mb-0">
                        <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                            for="grid-first-name">
                            Nilai Sewa/Hari
                        </InputLabel>
                        <TextInput id="grid-first-name" type="text" placeholder="0000" v-model="Form.nilaisewahari" />
                        <p v-if="Form.errors.nilaisewahari" class="text-red text-xs italic text-red-500">Please fill out
                            this field.</p>
                    </div>
                    <div class="md:w-1/2 px-3">
                        <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                            for="grid-last-name">
                            Nilai Sewa/Bulan
                        </InputLabel>
                        <TextInput id="grid-last-name" type="text" placeholder="0000" v-model="Form.nilaisewabulan" />
                        <p v-if="Form.errors.nilaisewabulan" class="text-red text-xs italic text-red-500">Please fill
                            out
                            this field.</p>
                    </div>
                </div>
                <hr class="my-2 h-px bg-gray-800 border-0 dark:bg-gray-700">
                <div class="-mx-3 grid grid-cols-1 sm:grid-cols-3 justify-center mb-6">
                    <div class="md:w-1/2 px-3 mb-4 md:mb-0">
                        <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                            for="grid-first-name">
                            Tanggal Sewa
                        </InputLabel>
                        <TextInput id="grid-first-name" type="date" placeholder="+62" />
                        <p v-if="Form.errors.tgl_sewa" class="text-red text-xs italic text-red-500">Please fill out this
                            field.</p>
                    </div>
                    <div class="md:w-1/2 px-3">
                        <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                            for="grid-last-name">
                            Tanggal Kembali
                        </InputLabel>
                        <TextInput id="grid-last-name" type="date" placeholder="+62" />
                        <p v-if="Form.errors.tgl_kembali" class="text-red text-xs italic text-red-500">Please fill out
                            this
                            field.</p>
                    </div>
                    <div class="md:w-1/2 px-3">
                        <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                            for="grid-last-name">
                            Lama Sewa
                        </InputLabel>
                        <TextInput id="grid-last-name" type="text" placeholder="...." />
                        <p v-if="Form.errors.lama_sewa" class="text-red text-xs italic text-red-500">Please fill out
                            this
                            field.</p>
                    </div>
                </div>
                <div class="-mx-3 grid grid-cols-1 sm:grid-cols-2 justify-center mb-2">
                    <div class="md:w-1/2 px-3 mb-4 md:mb-0">
                        <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                            for="grid-first-name">
                            Tujuan Penyewa
                        </InputLabel>
                        <TextInput id="grid-first-name" type="text" placeholder="......................" />
                        <p v-if="Form.errors.tujuan" class="text-red text-xs italic text-red-500">Please fill out this
                            field.</p>
                    </div>
                    <div class="md:w-1/2 px-3">
                        <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                            for="grid-last-name">
                            Jaminan Sewa
                        </InputLabel>
                        <TextInput id="grid-last-name" type="text" placeholder="......................" />
                        <p v-if="Form.errors.jaminan" class="text-red text-xs italic text-red-500">Please fill out this
                            field.</p>
                    </div>
                </div>
                <PrimaryButtonVue type="submit" class="block w-full mb-3 text-center">Lanjutkan</PrimaryButtonVue>
            </div>
        </form>
    </AuthenticatedLayoutVue>
</template>
<script>
import AuthenticatedLayoutVue from '../../Layouts/AuthenticatedLayout.vue'
import axios from 'axios';

export default {
    name: 'FormPinjamVue',
    components: {
        AuthenticatedLayoutVue
    },
    beforeMount: function () {
    },



}
</script>
