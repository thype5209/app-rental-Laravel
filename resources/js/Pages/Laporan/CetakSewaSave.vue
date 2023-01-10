<script setup>
import { defineProps, ref, onMounted } from 'vue';
import AuthenticatedLayoutVue from '@/Layouts/AuthenticatedLayout.vue';
import { Link, usePage } from '@inertiajs/inertia-vue3';
import PrimaryButtonVue from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue'
const data = defineProps({
    pdf: {
        type: String,
        default: () => ({})
    },
    sewa: {
        type: Object,
        default: () => ({})
    },
    sopir: {
        type: Object,
        default: () => ({})
    }
})
var jenis_sewa = null;
if(data.sewa.jenis_sewa === 'Lepas'){
    jenis_sewa = 'Lepas Kunci'
}else if(data.sewa.jenis_sewa === 'Kunci'){
    jenis_sewa = 'Dengan Driver'
}
const namaSopir = ref('');
onMounted(()=>{
})
if(data.sopir.length > 0){
    for (let index = 0; index < data.sopir.length; index++) {
        namaSopir.value += data.sopir[index].nama + ', ';
    }
}
console.log(namaSopir.value)
const myinput = window.location.origin + '/storage/' + data.pdf;
const myinputwa = `PEMAKAIAN DENGAN ${ jenis_sewa }
No. SPK :${ data.sewa.kode }
Nama Penyewa : ${ data.sewa.pengguna.nama }
Nama driver : ${ data.sopir.length > 0 ? namaSopir.value : '--' }
Jenis mobil : ${ data.sewa.unit }
No. Plat : ${ data.sewa.nopol }
Tgl Mulai-jam : ${ data.sewa.waktusewa.tgl_sewa }/${ data.sewa.waktusewa.jam_sewa } WITA
Tgl Selesai-jam :  ${ data.sewa.waktusewa.tgl_kembali }/${ data.sewa.waktusewa.jam_kembali } WITA
Jumlah Hari : ${ data.sewa.waktusewa.lama_sewa }
Zona : ${ data.sewa.tujuan }
Sewa Per Hari : ${ reduceArray(data.sewa.harga) }
Panjar / dp : Rp. ${ Number(data.sewa.total - data.sewa.sisa).toLocaleString() }
Ket.
${ data.sewa.list_pengiriman }`;
const input = ref(null)
const inputwa = ref(null)

onMounted(() => {
    console.log(myinput)
})
function copyPixCodeClick() {
    navigator.clipboard.writeText(myinput);
}
function copy() {
    input.value.focus()
    navigator.clipboard.writeText(myinput);

}
function copytext() {
    inputwa.value.focus()
    navigator.clipboard.writeText(myinputwa);
}
function reduceArray(array = [], lamasewa = 1) {
            var sisa = array.split(',');
            var harga = sisa.reduce((el, b) => Number(el) + Number(b));
            var total = (parseInt(harga) * lamasewa) ;
            return Number(total).toLocaleString();
        }

</script>
<template>
    <AuthenticatedLayoutVue>
        <div class="flex">
            <TextInput class="max-w-md" v-on:focus="$event.target.select()" ref="input" readonly :value="myinput" />
            <PrimaryButtonVue @click="copy">Copy Link</PrimaryButtonVue>

        </div>
        <div class="flex flex-col sm:flex-row justify-start py-3">
            <textarea name="textwa" id="textwa" ref="inputwa" v-on:focus="$event.target.select()" cols="50" rows="10" v-model="myinputwa">
            </textarea>
            <PrimaryButtonVue class=" w-full md:w-max" @click="copytext">Copy Text</PrimaryButtonVue>
        </div>
        <iframe :src="`/storage/${pdf}`" class="w-full h-screen"></iframe>

    </AuthenticatedLayoutVue>
</template>
