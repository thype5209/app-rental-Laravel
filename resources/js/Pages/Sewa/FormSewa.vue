<script setup>
import { Link, Head, useForm, usePage } from "@inertiajs/inertia-vue3";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import SelectVUe from "@/Components/Select.vue";
import PrimaryButtonVue from "@/Components/PrimaryButton.vue";
import { defineProps, ref, watch, onBeforeMount, onMounted, h } from "vue";
import ModalVue from "@/Components/Modal.vue";
import cardMobil from './cardMobil.vue';


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
// if (props.data.req != null && props.data.length > 0) {
//     const DataKembali = props.data.req.FormPDF;
//     dataInputSewa.nik = DataKembali.nik;
//     dataInputSewa.nama = DataKembali.nama;
//     dataInputSewa.tempat_lahir = DataKembali.tempat_lahir;
//     dataInputSewa.tgl_lahir = DataKembali.tgl_lahir;
//     dataInputSewa.alamat = DataKembali.alamat;
//     dataInputSewa.pekerjaan = DataKembali.pekerjaan;
//     dataInputSewa.sosial = DataKembali.sosial;
//     dataInputSewa.unit = DataKembali.unit;
//     dataInputSewa.no_hp = DataKembali.no_hp;
//     dataInputSewa.no_hp_lain = DataKembali.no_hp_lain;
//     dataInputSewa.nilaisewahari = DataKembali.nilaisewahari;
//     dataInputSewa.nilaisewabulan = DataKembali.nilaisewabulan;
//     dataInputSewa.tujuan = DataKembali.tujuan;
//     dataInputSewa.lama_sewa = DataKembali.lama_sew;
//     dataInputSewa.jaminan = DataKembali.jaminan;
//     dataInputSewa.panjar = DataKembali.panjar;
//     dataInputSewa.sisa = DataKembali.sisa;
//     dataInputSewa.lunas = DataKembali.lunas;
// }

const FOTOKTP = ref(null);
const Form = useForm({
    jenis_sewa: 'Lepas',
    foto_ktp: null,
    sopir_id: [],
    nik: null,
    nama: null,
    tempat_lahir: null,
    tgl_lahir: null,
    alamat: null,
    no_hp: null,
    no_hp_lain: null,
    pekerjaan: null,
    sosial: "FB",
    mobil_id: [],
    unit: [],
    nopol: [],
    tahun: [],
    nilaisewahari: [],
    nilaisewabulan: [],
    tgl_sewa: "2023-01-08",
    tgl_kembali: "2023-01-10",
    jam_sewa: "00:00",
    jam_kembali: "00:00",
    lama_sewa: "2",
    tujuan: "Makassar",
    jaminan: "KTP",
    panjar: '20000',
    sisa: '10000',
    lunas: false,
    metode_bayar: 'Transfer',
    list_pengiriman: null,
    ket_syarat: `<div class="">
            <h3 class=" font-bold">Ket.</h3>
            <ul class="list-disc  px-10">
                <li class="text-justify">Apabila penyewa akan memperpanjang sewa kendaraan maka harus di
                    konfirmasi
                    ke pihak rental.</li>
                <li class="text-justify">Jika penyewa terlamabat mengembalikan mobil dalam waktu yang di
                    tentukan
                    maka akan di kenakan biaya over time 10% per jam darai harga sewa per harinya</li>
                <li class="text-justify">Apa bila pemakain sewa kendaraan tidak sesuai dengan Tujuan penyewa
                    yang di
                    tentukan penyewa, maka akan di kenakan biaya tambahan sesuai dengan zona-zona yang berlaku.
                </li>
            </ul>
            <h3 class=" font-bold">Penyewa bersedia menyanggupi syarat dan ketentuan penyewa kendaraan di bawah
                ini
                :.</h3>
            <ul class="list-disc  px-10">
                <li>Bertanggung jawab segala kerusakan, kehilangan kendaraan atau bagian-bagiannya</li>
                <li>Kendaraan tersebut tidak dapat digadaikan atau merubah bentuk aslinya</li>
                <li>Pemilik tidak bertanggung jawab atas kegiatan operasionalpenyewa kendaraan</li>
                <li>Penyewa tidak di benarkan membawa kendaraan selain tujuan diatas</li>
                <li>Melunasi sewa mobil dan segala bentuk tagihan jika terjadi kerusakan dan biaya kerugian
                    selama
                    di bengkel.</li>
                <li>Penyewa bersedia dituntut pidana apabila melanggar poin-poin diatas</li>

            </ul>
        </div>`,
});
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
    Form.get(route("Sewa.formulir", { ktp: FOTOKTP }), {
        onError: (error) => console.log(error),
        preserveState: true,
    });
}

// Cek Foto KTP
watch(FOTOKTP, value => {
    const reader = new FileReader();

    reader.addEventListener("load", function () {
        // convert image file to base64 string and save to localStorage
        localStorage.setItem("image", reader.result);
    }, false);

    if (value != null) {
        reader.readAsDataURL(value);
    }
    console.log(value)
})

function returnslide() {
    if (slideMobil.value == 1 && Form.nik != null && Form.nama != null) {
        slideMobil.value = 2;
    }
    if (jumlahMobil.value == 2 || Form.unit.length > 0) {
        slideMobil.value += 1;
    }
    if (jumlahMobil.value == 3 || Form.unit.length > 0) {
        slideMobil.value = 4;
    }
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
const jmlSopir = ref(1);
function SelectSopir(event) {
    Form.sopir_id.push(event.target.value);
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
            if (response.data.status) {
                ModalShow.value = response.data.status;
            } else {
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
function reduceArray(array, lamasewa = 0) {
    var arrayToString = array.toString();
    var harga = null;
    if (arrayToString.indexOf(',') > -1) {
        var sisa = array.split(',');
        var harga = sisa.reduce((el, b) => Number(el) +''+ Number(b));
        console.log('sisa = '+ sisa);
        console.log('harga = '+ harga);
    } else {
        harga = array
        console.log('harga = '+ harga);
    }
    var total = (parseInt(harga) * lamasewa);
    console.log(total)
    return Number(total).toLocaleString();
}
function arraySum(array = []) {
    var hasil = null;
    if (array.length > 1) {
      hasil =  array.reduce((a, b) => {
            var asisa = a.split(',');
            var aharga = asisa.reduce((el, b) => el + b);
            var bsisa = b.split(',');
            var bharga = bsisa.reduce((el, b) => el + b);
            return Number(Number(aharga) + Number(bharga));
        });
    }else{
        hasil = array.reduce((a,b)=> { a+ b});
    }
    return hasil;
}


const slideMobil = ref(1);
const slidebayar = ref(false);
const jumlahPanjar = ref(0);
function funSlideMobil() {
    if (Form.nik != null && Form.nama && Form.alamat && Form.tempat_lahir != null && Form.tgl_lahir != null && Form.no_hp != null && Form.no_hp_lain != null) {
        slideMobil.value = true;
    }
}
function funSlideBayar() {
    slidebayar.value = true;
    slideMobil.value = false;
    // if (Form.mobil_id != null && Form.nilaisewahari && Form.nilaisewabulan && Form.unit != null && Form.nopol != null && Form.tahun != null && Form.tgl_sewa != null && Form.tgl_kembali != null && Form.tujuan != null && Form.jaminan != null) {
    // }
}
function cancelMObil() {
    slideMobil.value = false;
}
function cancelBayar() {
    slidebayar.value = false
}
function lunasfunc() {
    Form.lunas = !Form.lunas;
}

watch(jumlahPanjar, value => {
    var total = reduceArray(arraySum(Form.nilaisewahari), Form.lama_sewa);
    var sisa = total.split(',');
    var harga = sisa.reduce((el, b) => el + b);
    Form.sisa = harga - value;
    Form.panjar = value;
})

const jumlahMobil = ref(1);
watch(jumlahMobil, value => {
    jumlahMobil.value = value
})
</script>

<template>
    <AuthenticatedLayoutVue>

        <Head title="Sewa Form" />
        <!-- Modal Jika Masih Ada Sewa Belum Dibayar -->

        <!-- component -->
        <ModalVue :show="true" :maxWidth="`5xl`">
            <form @submit.prevent="submit">

                <!-- Slide Tambah Penyewa -->
                <div class="flex flex-col">
                    <span v-for="item in Form.errors" :key="item" class="bg-white w-full p-3">
                        {{ item }}
                    </span>
                </div>
                <div class="bg-gray-200 shadow-md rounded px-8 pt-6 mb-4 flex flex-col my-2" v-if="slideMobil == 1">
                    <div class="flex flex-row justify-left">
                        <Link :href="route('Sewa.index')">
                        <PrimaryButtonVue type="button" class="bg-default-dark">Kembali</PrimaryButtonVue>
                        </Link>
                    </div>
                    <nav class="flex justify-center gap-4 pb-5 py-5">
                        <PrimaryButtonVue @click="Form.jenis_sewa = 'Lepas'" type="button"
                            v-bind:class="Form.jenis_sewa == 'Lepas' ? TabActive : TabNonActive">Lepas Kunci
                        </PrimaryButtonVue>
                        <PrimaryButtonVue @click="Form.jenis_sewa = 'Kunci'" type="button"
                            v-bind:class="Form.jenis_sewa == 'Kunci' ? TabActive : TabNonActive">Dengan Driver
                        </PrimaryButtonVue>
                    </nav>

                    <div class="-mx-3 md:flex flex-col mb-6">
                        <div class="w-full px-3 relative z-10">
                            <InputLabel
                                class="block text-black uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
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
                        <div class="w-full px-3 relative pt-5">
                            <InputLabel
                                class="block text-black uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-first-name">Foto KTP Penyewa </InputLabel>
                            <TextInput id="grid-first-name" type="file" @input="FOTOKTP = $event.target.files[0]"
                                placeholder="Masukkan NIK" class="max-w-md" />
                            <p class="text-red text-xs italic text-gray-500">Ket: dapat dikosongkan</p>
                        </div>
                    </div>
                    <div class="-mx-3 md:flex mb-6">

                        <div class="md:w-1/2 px-3 mb-4 md:mb-0">
                            <InputLabel
                                class="block text-black uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-first-name">NIK</InputLabel>
                            <TextInput id="grid-first-name" type="text" placeholder="NIK" v-model="Form.nik" />
                            <p v-if="errors.nik" class="text-red text-xs italic text-red-500">Mohon Di Isi</p>
                        </div>
                        <div class="md:w-1/2 px-3">
                            <InputLabel
                                class="block text-black uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-last-name">Nama</InputLabel>
                            <TextInput id="grid-last-name" type="text" placeholder="Nama Lengkap" v-model="Form.nama" />
                            <p v-if="errors.nama" class="text-red text-xs italic text-red-500">Mohon Di Isi</p>
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
                            <p v-if="errors.tempat_lahir" class="text-red text-xs italic text-red-500">Mohon Di Isi</p>
                        </div>
                        <div class="md:w-1/2 px-3">
                            <InputLabel
                                class="block text-black uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-last-name">Alamat</InputLabel>

                            <TextInput id="grid-first-name" type="text" placeholder="Jane" v-model="Form.alamat" />
                            <p v-if="errors.tgl_lahir" class="text-red text-xs italic text-red-500">Mohon Di Isi</p>
                        </div>
                        <div class="md:w-1/2 px-3">
                            <InputLabel
                                class="block text-black uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-last-name">Pekerjaan</InputLabel>

                            <TextInput id="grid-first-name" type="text" placeholder="Jane" v-model="Form.pekerjaan" />
                            <p v-if="errors.pekerjaan" class="text-red text-xs italic text-red-500">Mohon Di Isi</p>
                        </div>
                    </div>
                    <div class="-mx-3 md:flex mb-6">
                        <div class="md:w-1/2 px-3 mb-4 md:mb-0">
                            <InputLabel
                                class="block text-black uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-first-name">Nomor HP</InputLabel>
                            <TextInput id="grid-first-name" type="tel" placeholder="+62" v-model="Form.no_hp" />
                            <p v-if="errors.no_hp" class="text-red text-xs italic text-red-500">Mohon Di Isi</p>
                        </div>
                        <div class="md:w-1/2 px-3 mb-4">
                            <InputLabel
                                class="block text-black uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-last-name">Nomor HP Kerabat lain</InputLabel>
                            <TextInput id="grid-last-name" type="tel" placeholder="+62" v-model="Form.no_hp_lain" />
                            <p v-if="errors.no_hp_lain" class="text-red text-xs italic text-red-500">Mohon Di Isi</p>
                        </div>
                        <div class="md:w-1/2 px-3 mb-4">
                            <InputLabel
                                class="block text-black uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-last-name">Sosial</InputLabel>
                            <TextInput id="grid-last-name" type="tel" placeholder="+62" v-model="Form.sosial" />
                        </div>
                    </div>
                    <div class="-mx-3 md:flex mb-6 items-center" v-if="Form.jenis_sewa == 'Kunci'" >
                        <div class="w-full px-3" >
                            <div v-for="jml in jmlSopir">
                                <InputLabel
                                class="block text-black uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-first-name">Nama Supir</InputLabel>
                            <SelectVUe class="block uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                id="mobil_id" for="grid-first-name" @change="SelectSopir($event)"
                                v-model="Form.sopir_id">
                                <option value="">---</option>
                                <option v-for="sopir in props.sopir" :key="sopir.id" :value="sopir.id">
                                    Nama= {{ sopir.nama }} | Nik= {{ sopir.nik }} | No.HP= {{ sopir.no_hp }}
                                </option>
                            </SelectVUe>
                            <p v-if="errors.mobil_id" class="text-red text-xs italic text-red-500">Mohon Di Isi</p>
                            </div>
                        </div>
                        <PrimaryButtonVue type="button" v-if="jmlSopir > 1" class="bg-red-500 text-lg hover:bg-red-600" @click="jmlSopir--">X</PrimaryButtonVue>
                        <PrimaryButtonVue type="button"  class="bg-default-dark text-lg hover:bg-default-dark" @click="jmlSopir++">+</PrimaryButtonVue>
                    </div>
                    <div class="mx-auto mb-3">
                        <PrimaryButtonVue type="button" class="bg-default-blue hover:bg-blue-600" @click="returnslide">
                            Selanjutnya
                        </PrimaryButtonVue>
                    </div>
                </div>

                <div class="inline-flex justify-center items-center w-full" v-if="slideMobil == 2">
                    <hr class="my-1 w-full h-1 bg-gray-200 rounded border-0 " />
                    <div class="absolute left-1/2 px-4 bg-white -translate-x-1/2 ">Detail Mobil</div>
                </div>
                <div class="bg-gray-200 shadow-md rounded px-8 pt-6 mb-4 flex flex-col my-2" v-if="slideMobil == 2">
                    <!-- Component Mobil -->
                    <div v-for="slid in jumlahMobil">
                        <cardMobil :mobil="props.mobil" :form="Form" :jumlah-mobil="slid"></cardMobil>
                    </div>
                    <PrimaryButtonVue type="button" @click="jumlahMobil++">Tambah Mobil</PrimaryButtonVue>


                    <!-- Waktu Sewa -->
                    <hr class="my-2 h-px bg-gray-800 border-0 " />
                    <div class="-mx-3 grid grid-cols-1 sm:grid-cols-3 justify-center mb-6">
                        <div class="md:w-full px-3 mb-4 md:mb-0">
                            <InputLabel
                                class="block text-black uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-first-name">Tanggal Sewa</InputLabel>
                            <TextInput id="grid-first-name" type="date" placeholder="+62" v-model="Form.tgl_sewa" />
                            <p v-if="1 < 2" class="text-red text-xs italic text-red-500">Mohon Di Isi</p>
                        </div>
                        <div class="md:w-full px-3">
                            <InputLabel
                                class="block text-black uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-last-name">Tanggal Kembali</InputLabel>
                            <TextInput id="grid-last-name" type="date" placeholder="+62" @change="getTanggal($event)"
                                v-model="Form.tgl_kembali" />
                            <p v-if="1 < 2" class="text-red text-xs italic text-red-500">Mohon Di Isi</p>
                        </div>
                        <div class="md:w-full px-3">
                            <InputLabel
                                class="block text-black uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-last-name">Lama Sewa</InputLabel>
                            <TextInput id="grid-last-name" type="text" placeholder="...." readonly
                                v-model="Form.lama_sewa" />
                            <!-- <p v-if="1 < 2" class="text-red text-xs italic text-red-500">Mohon Di Isi</p> -->
                        </div>
                    </div>

                    <!-- Jam Sewa -->
                    <div class="-mx-3 grid grid-cols-1 sm:grid-cols-3 justify-center mb-6">
                        <div class="md:w-full px-3 mb-4 md:mb-0">
                            <InputLabel
                                class="block text-black uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-first-name">Jam Sewa</InputLabel>
                            <TextInput id="grid-first-name" type="time" placeholder="+62" v-model="Form.jam_sewa" />
                            <p v-if="1 < 2" class="text-red text-xs italic text-red-500">Mohon Di Isi</p>
                        </div>
                        <div class="md:w-full px-3">
                            <InputLabel
                                class="block text-black uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-last-name">Jam Kembali</InputLabel>
                            <TextInput id="grid-last-name" type="time" placeholder="+62" v-model="Form.jam_kembali" />
                            <p v-if="1 < 2" class="text-red text-xs italic text-red-500">Mohon Di Isi</p>
                        </div>
                    </div>
                    <div class="-mx-3 grid grid-cols-1 sm:grid-cols-2 justify-center mb-2">
                        <div class="md:w-1/2 px-3 mb-4 md:mb-0">
                            <InputLabel
                                class="block text-black uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-first-name">Tujuan Penyewa</InputLabel>
                            <TextInput id="grid-first-name" type="text" placeholder="......................"
                                v-model="Form.tujuan" />
                            <p v-if="1 < 2" class="text-red text-xs italic text-red-500">Mohon Di Isi</p>
                        </div>
                        <div class="md:w-1/2 px-3">
                            <InputLabel
                                class="block text-black uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-last-name">Jaminan Sewa</InputLabel>
                            <TextInput id="grid-last-name" type="text" placeholder="......................"
                                v-model="Form.jaminan" />
                            <!-- <p v-if="1 < 2" class="text-red text-xs italic text-red-500">Mohon Di Isi</p> -->
                        </div>
                    </div>
                    <div class="flex justify-around">
                        <PrimaryButtonVue type="button" @click="slideMobil--"
                            class=" mb-3 text-center bg-red-500 disabled:bg-red-600 disabled:text-gray-300">Sebelumnya
                        </PrimaryButtonVue>
                        <PrimaryButtonVue type="button"
                            class=" mb-3 text-center disabled:bg-red-600 disabled:text-gray-300" @click="slideMobil++">
                            Selanjutnya</PrimaryButtonVue>
                    </div>
                </div>


                <!-- Detail Pembayaran -->
                <div class="inline-flex justify-center items-center w-full" v-if="slideMobil == 3">
                    <hr class="my-1 w-full h-1 bg-gray-200 rounded border-0 " />
                    <div class="absolute left-1/2 px-4 bg-white -translate-x-1/2 ">Detail Pembayaran</div>
                </div>
                <div class="bg-gray-200 shadow-md rounded px-8 pt-6 mb-4 flex flex-col my-2" v-if="slideMobil == 3">
                    <!-- Pembayran Sewa -->

                    <div class="-mx-3 sm:flex mb-6 px-3">
                        <InputLabel class=" text-black uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                            for="grid-last-name">Lunas</InputLabel>
                        <TextInput class="w-max ml-3" type="checkbox" id="checkbox" placeholder="Jumlah Panjar"
                            @click="lunasfunc" />
                        <p class="text-red text-xs italic text-gray-500 ml-4">
                            Jika Pembayaran Telah Lunas Mohon Di Centang
                        </p>
                    </div>
                    <div class="-mx-3 sm:flex mb-6">
                        <div class="sm:w-1/3 px-3">
                            <InputLabel
                                class="block text-black uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-last-name">Panjar</InputLabel>
                            <TextInput id="grid-last-name" type="text" placeholder="Jumlah Panjar"
                                v-model="jumlahPanjar" />
                            <p v-if="errors.panjar" class="text-red text-xs italic text-red-500">Mohon Di Isi</p>
                        </div>
                        <div class="sm:w-1/3 px-3">
                            <InputLabel
                                class="block text-black uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-first-name">Sisa Bayar</InputLabel>
                            <TextInput id="grid-last-name" class="1/2" type="text" placeholder="Sisa Bayar"
                                v-model="Form.sisa" />
                            <p v-if="errors.sisa" class="text-red text-xs italic text-red-500">Mohon Di Isi</p>
                        </div>
                        <div class="sm:w-1/2 px-3">
                            <InputLabel
                                class="block text-black uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                                for="grid-last-name">Total</InputLabel>
                            <TextInput id="grid-first-name" type="text" placeholder="0000" readonly required
                                :value="reduceArray(arraySum(Form.nilaisewahari), Form.lama_sewa)" />
                            <p v-if="errors.lunas" class="text-red text-xs italic text-red-500">Mohon Di Isi</p>
                        </div>

                    </div>
                    <div class="mb-5">

                        <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">Metode Pembayaran</h3>
                        <ul
                            class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                <div class="flex items-center pl-3">
                                    <input id="horizontal-list-radio-license" type="radio" v-model="Form.metode_bayar"
                                        chec value="Transfer" name="list-radio"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="horizontal-list-radio-license"
                                        class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Transfer</label>
                                </div>
                            </li>
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                <div class="flex items-center pl-3">
                                    <input id="horizontal-list-radio-id" type="radio" v-model="Form.metode_bayar"
                                        value="Cash" name="list-radio"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="horizontal-list-radio-id"
                                        class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Cash</label>
                                </div>
                            </li>
                        </ul>

                    </div>
                    <div class="mb-5">

                        <p class=" font-semibold text-gray-900 dark:text-white text-sm lowercase">Isi Kolom Input
                            Dibawah Dengan Detail Pengiriman Mobil Apakah Diambil Ditempat Atau Dikirim Ke Penyewa</p>
                        <TextInput type="text" v-model="Form.list_pengiriman"
                            placeholder="Isikan Keterangan Pengambilan" required />

                    </div>
                    <div class="flex justify-around">
                        <PrimaryButtonVue type="button" @click="slideMobil--"
                            class=" mb-3 text-center bg-red-500 disabled:bg-red-600 disabled:text-gray-300">Sebelumnya
                        </PrimaryButtonVue>
                        <PrimaryButtonVue type="button"
                            class=" mb-3 text-center disabled:bg-red-600 disabled:text-gray-300" @click="returnslide">
                            Lanjutkan</PrimaryButtonVue>

                    </div>
                </div>
                <!-- Keterangan Dan Syarat Sewa -->
                <div class="inline-flex justify-center items-center w-full" v-if="slideMobil == 4">
                    <hr class="my-1 w-full h-1 bg-gray-200 rounded border-0 " />
                    <div class="absolute left-1/2 px-4 bg-white -translate-x-1/2 ">Keterangan Dan Syarat Sewa</div>
                </div>
                <div class="bg-gray-200 shadow-md rounded md:px-8 pt-6 mb-4 flex flex-col my-2" v-if="slideMobil == 4">
                    <ckeditor :editor="editor" v-model="Form.ket_syarat" :config="editorConfig"></ckeditor>

                    <div class="flex justify-around">
                        <PrimaryButtonVue type="button" @click="slideMobil--"
                            class=" mb-3 text-center bg-red-500 disabled:bg-red-600 disabled:text-gray-300">Sebelumnya
                        </PrimaryButtonVue>
                        <PrimaryButtonVue type="submit"
                            class=" mb-3 text-center disabled:bg-red-600 disabled:text-gray-300"
                            v-if="ModalShow == false">Lanjutkan</PrimaryButtonVue>
                        <PrimaryButtonVue type="button"
                            class="block w-full mb-3 text-center disabled:bg-red-600 disabled:text-gray-300" disabled
                            v-else>Error Akses Ditolak</PrimaryButtonVue>
                    </div>
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
                                    <td class="sm:px-2 sm:py-1 text-xs capitalize border whitespace-nowrap">Harga Sewa
                                    </td>
                                    <td class="sm:px-2 sm:py-1 text-xs capitalize border whitespace-nowrap">Lama Sewa
                                    </td>
                                    <td class="sm:px-2 sm:py-1 text-xs capitalize border whitespace-nowrap">Tanggal Sewa
                                    </td>
                                    <td class="sm:px-2 sm:py-1 text-xs capitalize border whitespace-nowrap">Tanggal
                                        Kembali
                                    </td>
                                    <td class="sm:px-2 sm:py-1 text-xs capitalize border whitespace-nowrap">Status</td>
                                    <td class="sm:px-2 sm:py-1 text-xs capitalize border whitespace-nowrap">Total</td>
                                </tr>
                                <tr v-for="(item, index) in Tunggakan" :key="item" :index="index">
                                    <td class='text-xs p-1.5 capitalize border whitespace-nowrap'>{{ item.kode }}</td>
                                    <td class='text-xs p-1.5 capitalize border whitespace-nowrap'>{{ item.harga }}</td>
                                    <td class='text-xs p-1.5 capitalize border whitespace-nowrap'>{{
                                        item.waktusewa.lama_sewa
                                    }}</td>
                                    <td class='text-xs p-1.5 capitalize border whitespace-nowrap'>{{
                                        item.waktusewa.tgl_sewa
                                    }}</td>
                                    <td class='text-xs p-1.5 capitalize border whitespace-nowrap'>{{
                                        item.waktusewa.tgl_kembali
                                    }}</td>
                                    <td class='text-xs p-1.5 capitalize border whitespace-nowrap'>{{ item.status }}</td>
                                    <td class='text-xs p-1.5 capitalize border whitespace-nowrap'>{{
                                        reduceArray(item.sisa,1,item.denda)
                                    }} </td>
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
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import CKEditor from '@ckeditor/ckeditor5-vue';


export default {
    name: "FormPinjamVue",
    components: {
        AuthenticatedLayoutVue,
        ckeditor: CKEditor.component,
    },
    data() {
        return {
            editor: ClassicEditor,

            editorConfig: {
                toolbar: ['bold', 'italic', '|', 'NumberedList', 'BulletedList',
                    // { name: 'paragraph', items: [ '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language'] },
                    // { name: 'links', items: ['Link', 'Unlink', 'Anchor'] },
                ],

            }
        };
    },
    beforeMount: function () { }
};
</script>
