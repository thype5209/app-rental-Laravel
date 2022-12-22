<script setup>
import { Link, Head, useForm, usePage } from "@inertiajs/inertia-vue3";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import SelectVUe from "@/Components/Select.vue";
import PrimaryButtonVue from "@/Components/PrimaryButton.vue";
import { defineProps, ref, watch, onBeforeMount, onMounted, h } from "vue";
import ModalVue from "@/Components/Modal.vue";

const props = defineProps({
    pengguna: {
        type: Object,
        default: () => ({})
    },
    mobil: {
        type: Object,
        default: () => ({})
    },
    sopir: {
        type: Object,
        default: () => ({})
    },
    data: {
        type: Object,
        default: {}
    },
    errors: Object
});
const dataInputSewa = {
    jenis_sewa: '',
    sopir_id: '',
    nik: "",
    nama: "",
    tempat_lahir: "",
    tgl_lahir: "",
    alamat: "",
    no_hp: "",
    no_hp_lain: "",
    pekerjaan: "",
    sosial: "FB",
    mobil_id: "",
    unit: "",
    nopol: "",
    tahun: "",
    nilaisewahari: "",
    nilaisewabulan: "",
    tgl_sewa: "",
    tgl_kembali: "",
    lama_sewa: "",
    tujuan: "",
    jaminan: ""
};

if (props.data.req != null && props.data.length > 0) {
    const DataKembali = props.data.req.FormPDF;
    dataInputSewa.nik = DataKembali.nik;
    dataInputSewa.nama = DataKembali.nama;
    dataInputSewa.tempat_lahir = DataKembali.tempat_lahir;
    dataInputSewa.tgl_lahir = DataKembali.tgl_lahir;
    dataInputSewa.alamat = DataKembali.alamat;
    dataInputSewa.pekerjaan = DataKembali.pekerjaan;
    dataInputSewa.sosial = DataKembali.sosial;
    dataInputSewa.unit = DataKembali.unit;
    dataInputSewa.no_hp = DataKembali.no_hp;
    dataInputSewa.no_hp_lain = DataKembali.no_hp_lain;
    dataInputSewa.nilaisewahari = DataKembali.nilaisewahari;
    dataInputSewa.nilaisewabulan = DataKembali.nilaisewabulan;
    dataInputSewa.tujuan = DataKembali.tujuan;
    dataInputSewa.lama_sewa = DataKembali.lama_sew;
    dataInputSewa.jaminan = DataKembali.jaminan;
}


const Form = useForm(dataInputSewa);
var TabActive =
    "bg-green-500 py-2 md:px-6 block hover:text-green-500 focus:outline-none text-white border-b-2 font-medium border-default-dark";
var TabNonActive =
    "text-gray-600 bg-blue-500 py-2 md:px-6 block hover:text-blue-500 focus:outline-none";
Form.jenis_sewa = ref("Lepas");



// Fungsi Cari Mobil Dengan Select ID
function GetMobil(event) {
    axios
        .get("/Mobil/GetIDMobil/" + event.target.value)
        .then(function (response) {
            const mobil = response.data;
            Form.unit = mobil.unit;
            Form.nopol = mobil.nopol;
            Form.tahun = mobil.tahun;
            Form.nilaisewahari = Number(mobil.harga).toLocaleString();
            Form.nilaisewabulan = Number(mobil.harga * 30).toLocaleString();
            Form.mobil_id = mobil.id;
        })
        .catch(errors => console.log(errors));
}

// Kirim Data
function submit() {
    Form.post(route("Sewa.formulir"), { preserveState: true });
}


// Fungsi Lama Sewa
function diff_date(date1, date2) {
    var d = Math.abs(date1 - date2) / 1000; // delta
    var r = {}; // result
    var s = {
        // structure
        year: 31536000,
        month: 2592000,
        week: 604800, // uncomment row to ignore
        day: 86400, // feel free to add your own row
        hour: 3600,
        minute: 60,
        second: 1
    };
    // hitung perbedaan waktu dari dua tanggal
    var Difference_In_Time = date2 - date1;

    // hitung jml hari antara dua tanggal
    var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);

    Object.keys(s).forEach(function (key) {
        r[key] = Math.floor(d / s[key]);
        d -= r[key] * s[key];
    });
    return Difference_In_Days;
}
// Cetak Tanggal
function getTanggal(event) {
    var tgl_pengajuan = new Date(Form.tgl_sewa);
    var tgl_kembali = new Date(event.target.value);
    var diff = diff_date(tgl_pengajuan, tgl_kembali);
    Form.lama_sewa = diff;
}

function SelectSopir(event) {
    Form.sopir_id = event.target.value;
}

// Fungsi Cari Pengguna Dengan Nik
const SearchNIK = ref('')
let ulNik = ref({});
const NIKPengguna = ref(null)

// Modal variabel
const ModalShow = ref(false);
// ref untuk tunggakan
const Tunggakan = ref(Object)
function isClose() {
    ModalShow.value = false;
}


function CariNIK(event) {
    axios.get(route('Pengguna.GetID', { id: event.target.value }))
        .then(response => {
            Form.nik = response.data.query.nik;
            Form.nama = response.data.query.nama;
            Form.tempat_lahir = response.data.query.tempat_lahir;
            Form.tgl_lahir = response.data.query.tgl_lahir;
            Form.no_hp = response.data.query.no_hp;
            Form.no_hp_lain = response.data.query.no_hp_lain;
            Form.alamat = response.data.query.alamat;
            Form.pekerjaan = response.data.query.pekerjaan;
            Tunggakan.value = response.data.query.sewa
            if(response.data.status){
                ModalShow.value = response.data.status;
            }else{
                ModalShow.value = response.data.status;
            }
        }).catch(error => console.log(error))

}
watch(SearchNIK, value => {
    axios.get(route('Pengguna.CariNIK', { search: value })).then((response) => {
        var li = "";
        if (response.data.length > 0) {
            response.data.forEach(element => {
                // li+= `<option class="text-sm text-gray-500 border-b px-3 cursor-pointer py-2 hover:bg-gray-200" v-bind:on-click="CariNIK(${element.nik},${element.nama},${element.tempat_lahir},${element.tgl_lahir},${element.no_hp},${element.no_hp_lain},${element.alamat},${element.pekerjaan})">${element.nama}</option>`;
                li += `<option class="text-sm text-gray-500 border-b px-3 cursor-pointer py-2 hover:bg-gray-200" value="${element.id}">${element.nama}</option>`;
            });
            ulNik = li;
        } else {
            ulNik = `<option class="text-sm text-gray-500 border-b px-3 cursor-pointer py-2 hover:bg-gray-200">Tidak Ada</option>`
        }
    })
})
// End

function reduceArray(array, lamasewa) {
    var sisa = array.split(',');
    var harga = sisa.reduce((el, b) => el + b);

    return Number(parseInt(harga) * lamasewa).toLocaleString();
}
</script>

<template>
    <AuthenticatedLayoutVue>

        <Head title="Sewa Form" />
        <!-- Modal Jika Masih Ada Sewa Belum Dibayar -->

        <!-- component -->
        <ModalVue :show="true" :maxWidth="`5xl`">
            <form @submit.prevent="submit" >
                <div class="bg-gray-200 shadow-md rounded px-8 pt-6 mb-4 flex flex-col my-2">
                    <div class="flex flex-row justify-left">
                        <Link :href="route('Sewa.index')">
                        <PrimaryButtonVue type="button" class="bg-red-500">Kembali</PrimaryButtonVue>
                        </Link>
                    </div>
                    <nav class="flex justify-center gap-4 pb-5">
                        <PrimaryButtonVue @click="Form.jenis_sewa = 'Lepas'"
                            v-bind:class="Form.jenis_sewa == 'Lepas' ? TabActive : TabNonActive">Lepas Kunci
                        </PrimaryButtonVue>
                        <PrimaryButtonVue @click="Form.jenis_sewa = 'Kunci'"
                            v-bind:class="Form.jenis_sewa == 'Kunci' ? TabActive : TabNonActive">Kunci</PrimaryButtonVue>
                    </nav>

                    <div class="-mx-3 md:flex mb-6" v-if="Form.jenis_sewa == 'Lepas'">
                        <div class="w-full px-3 relative">
                            <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-first-name">Pilih Pengguna </InputLabel>
                            <TextInput id="grid-first-name" type="search" placeholder="Masukkan NIK" class="max-w-md"
                                v-model="SearchNIK" />
                            <div v-if="SearchNIK != ''"
                                class="HasilNik bg-white shadow-lg rounded-md py-1 w-64 absolute box-border">
                                <SelectVUe v-model="NIKPengguna" v-html="ulNik" multiple @change="CariNIK($event)"
                                    @mouseleave="SearchNIK = ''">

                                </SelectVUe>
                            </div>
                            <p class="text-red text-xs italic text-gray-500">Cari Data Pengguna Yang Ada</p>
                        </div>
                    </div>
                    <div class="-mx-3 md:flex mb-6" v-if="Form.jenis_sewa == 'Lepas'">

                        <div class="md:w-1/2 px-3 mb-4 md:mb-0">
                            <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-first-name">NIK</InputLabel>
                            <TextInput id="grid-first-name" type="text" placeholder="Jane" v-model="Form.nik" />
                            <p v-if="errors.nik" class="text-red text-xs italic text-red-500">Mohon Di Isi</p>
                        </div>
                        <div class="md:w-1/2 px-3">
                            <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-last-name">Nama</InputLabel>
                            <TextInput id="grid-last-name" type="text" placeholder="Nama Lengkap" v-model="Form.nama" />
                            <p v-if="errors.nama" class="text-red text-xs italic text-red-500">Mohon Di Isi</p>
                        </div>
                    </div>
                    <div class="-mx-3 md:flex mb-6" v-if="Form.jenis_sewa == 'Lepas'">
                        <div class="md:w-1/2 px-3 mb-4 md:mb-0">
                            <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-first-name">Tempat/Tanggal Lahir</InputLabel>
                            <div class="flex">
                                <TextInput id="grid-last-name" class="1/2" type="text" placeholder="Tempat Lahir"
                                    v-model="Form.tempat_lahir" />
                                <TextInput id="grid-last-name" class="1/2" type="date" placeholder="Doe"
                                    v-model="Form.tgl_lahir" />
                            </div>
                            <p v-if="errors.tempat_lahir" class="text-red text-xs italic text-red-500">Mohon Di Isi</p>
                        </div>
                        <div class="md:w-1/2 px-3">
                            <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-last-name">Alamat</InputLabel>

                            <TextInput id="grid-first-name" type="text" placeholder="Jane" v-model="Form.alamat" />
                            <p v-if="errors.tgl_lahir" class="text-red text-xs italic text-red-500">Mohon Di Isi</p>
                        </div>
                        <div class="md:w-1/2 px-3">
                            <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-last-name">Pekerjaan</InputLabel>

                            <TextInput id="grid-first-name" type="text" placeholder="Jane" v-model="Form.pekerjaan" />
                            <p v-if="errors.pekerjaan" class="text-red text-xs italic text-red-500">Mohon Di Isi</p>
                        </div>
                    </div>
                    <div class="-mx-3 md:flex mb-6" v-if="Form.jenis_sewa == 'Lepas'">
                        <div class="md:w-1/2 px-3 mb-4 md:mb-0">
                            <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-first-name">Nomor HP</InputLabel>
                            <TextInput id="grid-first-name" type="tel" placeholder="+62" v-model="Form.no_hp" />
                            <p v-if="errors.no_hp" class="text-red text-xs italic text-red-500">Mohon Di Isi</p>
                        </div>
                        <div class="md:w-1/2 px-3 mb-4">
                            <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-last-name">Nomor HP Kerabat lain</InputLabel>
                            <TextInput id="grid-last-name" type="tel" placeholder="+62" v-model="Form.no_hp_lain" />
                            <p v-if="errors.no_hp_lain" class="text-red text-xs italic text-red-500">Mohon Di Isi</p>
                        </div>
                        <div class="md:w-1/2 px-3 mb-4">
                            <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-last-name">Sosial</InputLabel>
                            <TextInput id="grid-last-name" type="tel" placeholder="+62" v-model="Form.sosial" />
                        </div>
                    </div>
                    <div class="-mx-3 md:flex mb-6" v-if="Form.jenis_sewa == 'Kunci'">
                        <div class="w-full px-3">
                            <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-first-name">Nama Supir</InputLabel>
                            <SelectVUe class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                id="mobil_id" for="grid-first-name" @change="SelectSopir($event)" v-model="Form.sopir_id">
                                <option value="">---</option>
                                <option v-for="sopir in props.sopir" :key="sopir.id" :value="sopir.id">
                                    Nama= {{ sopir.nama }} | Nik= {{ sopir.nik }} | No.HP= {{ sopir.no_hp }}
                                </option>
                            </SelectVUe>
                            <p v-if="errors.mobil_id" class="text-red text-xs italic text-red-500">Mohon Di Isi</p>
                        </div>
                    </div>
                </div>

                <div class="inline-flex justify-center items-center w-full">
                    <hr class="my-1 w-full h-1 bg-gray-200 rounded border-0 " />
                    <div class="absolute left-1/2 px-4 bg-white -translate-x-1/2 ">Detail Mobil</div>
                </div>
                <div class="bg-gray-200 shadow-md rounded px-8 pt-6 mb-4 flex flex-col my-2">
                    <div class="-mx-3 md:flex mb-6">
                        <div class="w-full px-3">
                            <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-first-name">Jenis Mobil</InputLabel>
                            <SelectVUe class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                id="mobil_id" for="grid-first-name" @change="GetMobil($event)">
                                <option value>---</option>
                                <option v-for="mobil in props.mobil" :key="mobil.id" :value="mobil.id">Unit= {{ mobil.unit
                                }} | Nopol= {{ mobil.nopol }} | Tahun= {{ mobil.tahun }}</option>
                            </SelectVUe>
                            <p v-if="errors.mobil_id" class="text-red text-xs italic text-red-500">Mohon Di Isi</p>
                        </div>
                    </div>
                    <div class="-mx-3 sm:flex mb-6">
                        <div class="sm:w-1/3 px-3">
                            <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-last-name">Jenis Kendaraan</InputLabel>
                            <TextInput id="grid-last-name" type="text" placeholder="Jenis Kendaraan" readonly required
                                v-model="Form.unit" />
                            <p v-if="errors.unit" class="text-red text-xs italic text-red-500">Mohon Di Isi</p>
                        </div>
                        <div class="sm:w-1/3 px-3">
                            <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-first-name">No. Kendaraan</InputLabel>
                            <TextInput id="grid-last-name" class="1/2" type="text" placeholder="No. Kendaraan" readonly
                                required v-model="Form.nopol" />
                            <p v-if="errors.nopol" class="text-red text-xs italic text-red-500">Mohon Di Isi</p>
                        </div>
                        <div class="sm:w-1/2 px-3">
                            <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-last-name">Tahun</InputLabel>

                            <TextInput id="grid-first-name" type="number" placeholder="0000" readonly required
                                v-model="Form.tahun" />
                            <p v-if="errors.tahun" class="text-red text-xs italic text-red-500">Mohon Di Isi</p>
                        </div>
                    </div>
                    <div class="-mx-3 sm:flex justify-center w-full">
                        <div class="md:w-1/2 px-3 mb-4 md:mb-0">
                            <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-first-name">Nilai Sewa/Hari</InputLabel>
                            <TextInput id="grid-first-name" type="text" readonly placeholder="0000" v-model="Form.nilaisewahari" />
                            <p v-if="errors.nilaisewahari" class="text-red text-xs italic text-red-500">
                                Please fill out
                                this field.
                            </p>
                        </div>
                        <div class="md:w-1/2 px-3">
                            <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-last-name">Nilai Sewa/Bulan</InputLabel>
                            <TextInput id="grid-last-name" type="text" readonly placeholder="0000" v-model="Form.nilaisewabulan" />
                            <p v-if="errors.nilaisewabulan" class="text-red text-xs italic text-red-500">
                                Please fill
                                out
                                this field.
                            </p>
                        </div>
                    </div>
                    <hr class="my-2 h-px bg-gray-800 border-0 " />
                    <div class="-mx-3 grid grid-cols-1 sm:grid-cols-3 justify-center mb-6">
                        <div class="md:w-full px-3 mb-4 md:mb-0">
                            <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-first-name">Tanggal Sewa</InputLabel>
                            <TextInput id="grid-first-name" type="date" placeholder="+62" v-model="Form.tgl_sewa" />
                            <p v-if="errors.tgl_sewa" class="text-red text-xs italic text-red-500">Mohon Di Isi</p>
                        </div>
                        <div class="md:w-full px-3">
                            <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-last-name">Tanggal Kembali</InputLabel>
                            <TextInput id="grid-last-name" type="date" placeholder="+62" @change="getTanggal($event)"
                                v-model="Form.tgl_kembali" />
                            <p v-if="errors.tgl_kembali" class="text-red text-xs italic text-red-500">Mohon Di Isi</p>
                        </div>
                        <div class="md:w-full px-3">
                            <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-last-name">Lama Sewa</InputLabel>
                            <TextInput id="grid-last-name" type="text" placeholder="...." v-model="Form.lama_sewa" />
                            <p v-if="errors.lama_sewa" class="text-red text-xs italic text-red-500">Mohon Di Isi</p>
                        </div>
                    </div>
                    <div class="-mx-3 grid grid-cols-1 sm:grid-cols-2 justify-center mb-2">
                        <div class="md:w-1/2 px-3 mb-4 md:mb-0">
                            <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-first-name">Tujuan Penyewa</InputLabel>
                            <TextInput id="grid-first-name" type="text" placeholder="......................"
                                v-model="Form.tujuan" />
                            <p v-if="errors.tujuan" class="text-red text-xs italic text-red-500">Mohon Di Isi</p>
                        </div>
                        <div class="md:w-1/2 px-3">
                            <InputLabel class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-last-name">Jaminan Sewa</InputLabel>
                            <TextInput id="grid-last-name" type="text" placeholder="......................"
                                v-model="Form.jaminan" />
                            <!-- <p v-if="errors.jaminan" class="text-red text-xs italic text-red-500">Mohon Di Isi</p> -->
                        </div>
                    </div>
                    <PrimaryButtonVue type="submit" class="block w-full mb-3 text-center disabled:bg-red-600 disabled:text-gray-300" v-if="ModalShow == false">Lanjutkan</PrimaryButtonVue>
                    <PrimaryButtonVue type="submit" class="block w-full mb-3 text-center disabled:bg-red-600 disabled:text-gray-300" disabled v-else>Error Akses Ditolak</PrimaryButtonVue>
                </div>
            </form>
            <ModalVue :show="ModalShow" :max-width="`2xl`" @close="isClose()">
                <div class="relative w-full h-full md:h-auto">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow ">
                        <button type="button" @click="ModalShow = false"
                            class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center  "
                            data-modal-toggle="authentication-modal">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                        <div class="px-6 py-6 lg:px-8 flex flex-col justify-center">
                            <h1 class="text-base font-semibold  uppercase text-center py-2 overflow-auto">Tunggakan
                                Penyewaan Belum Di Bayar</h1>
                            <table class="table w-full">
                                <tr>
                                    <td class="sm:px-2 sm:py-1 text-xs capitalize border whitespace-nowrap">Kode</td>
                                    <td class="sm:px-2 sm:py-1 text-xs capitalize border whitespace-nowrap">Harga Sewa</td>
                                    <td class="sm:px-2 sm:py-1 text-xs capitalize border whitespace-nowrap">Lama Sewa</td>
                                    <td class="sm:px-2 sm:py-1 text-xs capitalize border whitespace-nowrap">Tanggal Sewa
                                    </td>
                                    <td class="sm:px-2 sm:py-1 text-xs capitalize border whitespace-nowrap">Tanggal Kembali
                                    </td>
                                    <td class="sm:px-2 sm:py-1 text-xs capitalize border whitespace-nowrap">Status</td>
                                    <td class="sm:px-2 sm:py-1 text-xs capitalize border whitespace-nowrap">Total</td>
                                </tr>
                                <tr v-for="(item, index) in Tunggakan" :key="item" :index="index">
                                    <td class='text-xs p-1.5 capitalize border whitespace-nowrap'>{{ item.kode }}</td>
                                    <td class='text-xs p-1.5 capitalize border whitespace-nowrap'>{{ item.harga }}</td>
                                    <td class='text-xs p-1.5 capitalize border whitespace-nowrap'>{{ item.waktusewa.lama_sewa }}</td>
                                    <td class='text-xs p-1.5 capitalize border whitespace-nowrap'>{{ item.waktusewa.tgl_sewa }}</td>
                                    <td class='text-xs p-1.5 capitalize border whitespace-nowrap'>{{ item.waktusewa.tgl_kembali }}</td>
                                    <td class='text-xs p-1.5 capitalize border whitespace-nowrap'>{{ item.status }}</td>
                                    <td class='text-xs p-1.5 capitalize border whitespace-nowrap'>{{ reduceArray(item.harga, item.waktusewa.lama_sewa) }} </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </ModalVue>
        </ModalVue>
    </AuthenticatedLayoutVue>
</template>
<script>
import AuthenticatedLayoutVue from "../../Layouts/AuthenticatedLayout.vue";
import axios from "axios";

export default {
    name: "FormPinjamVue",
    components: {
        AuthenticatedLayoutVue
    },
    beforeMount: function () { }
};
</script>
