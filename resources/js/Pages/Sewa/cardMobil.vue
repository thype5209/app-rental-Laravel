<script setup>
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import SelectVUe from "@/Components/Select.vue";
import PrimaryButtonVue from "@/Components/PrimaryButton.vue";
import { defineProps, ref, watch, onBeforeMount, onMounted, h } from "vue";
const props = defineProps({
    mobil: Object,
    form: Object,
    jumlahMobil: Number
})
const platMobil = ref('');

var arrmobil = new Array();
const MobilForm = {
    mobil_id: [],
    unit: [],
    nopol: [],
    tahun: [],
    nilaisewahari: [],
    nilaisewabulan: [],
}

// Fungsi Cari Mobil Dengan Select ID
function GetMobil(event, jumlahMobil) {
    console.log(event.target.value)
    axios.get("/Mobil/GetIDMobil/" + event.target.value)
        .then(function (response) {
            const mobil = response.data;
            props.form.unit[jumlahMobil] = mobil.unit
            props.form.nopol[jumlahMobil] = mobil.nopol
            props.form.tahun[jumlahMobil] = mobil.tahun
            props.form.nilaisewahari[jumlahMobil] = Number(mobil.harga)
            props.form.nilaisewabulan[jumlahMobil] = Number(mobil.harga * 30)
            props.form.mobil_id[jumlahMobil] = mobil.id
            arrmobil.push(MobilForm);
            window.localStorage.setItem('mobil_id', arrmobil)
            platMobil.value = '';
        })
        .catch(errors => console.log(errors));
}

const ulNik = ref({});

watch(platMobil, value => {
    axios
        .get("/Mobil/cariMobil/"+ value)
        .then(function (response) {
            console.log(response)
            var li = "";
            if (response.data.length > 0) {
                response.data.forEach(element => {
                    // li+= `<option class="text-sm text-gray-500 border-b px-3 cursor-pointer py-2 hover:bg-gray-200" v-bind:on-click="CariNIK(${element.nik},${element.nama},${element.tempat_lahir},${element.tgl_lahir},${element.no_hp},${element.no_hp_lain},${element.alamat},${element.pekerjaan})">${element.nama}</option>`;
                    li += `<option class="text-sm text-gray-500 border-b px-3 cursor-pointer py-2 hover:bg-gray-200" value="${element.id}">${element.nopol}</option>`;
                });
                ulNik.value = li;
            } else {
                ulNik.value = `<option class="text-sm text-gray-500 border-b px-3 cursor-pointer py-2 hover:bg-gray-200">Tidak Ada</option>`
            }
        })
        .catch(errors => console.log(errors));
})
</script>

<template>

    <div class="-mx-3 md:flex mb-6 items-center">
        <div class="w-full px-3">
            <InputLabel class="block text-black uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                for="grid-first-name">Jenis Mobil {{ jumlahMobil }} </InputLabel>
            <TextInput id="grid-last-name" type="text" placeholder="Jenis Kendaraan/Unit" required
                v-model="platMobil" />
            <div v-if="platMobil != ''">
                <SelectVUe  id="mobil_id"  class="absolute" multiple
                for="grid-first-name" v-html="ulNik" @change="GetMobil($event, jumlahMobil)" @mouseleave="platMobil = ''">
            </SelectVUe>
            </div>
            <p class="text-red text-xs italic text-gray-500">Mohon Di Isi</p>
        </div>
        <!-- <PrimaryButtonVue type="button" v-if="jumlahMobil > 1" @click="jumlahMobil--" class="bg-red-500 rounded-lg text-lg">X</PrimaryButtonVue> -->
    </div>
    <div class="-mx-3 sm:flex mb-6">
        <div class="sm:w-1/3 px-3">
            <InputLabel class="block text-black uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                for="grid-last-name">Jenis Kendaraan</InputLabel>
            <TextInput id="grid-last-name" type="text" placeholder="Jenis Kendaraan/Unit" required
                v-model="props.form.unit[jumlahMobil]" />
            <p class="text-red text-xs italic text-gray-500">Mohon Di Isi</p>
        </div>
        <div class="sm:w-1/3 px-3">
            <InputLabel class="block text-black uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                for="grid-first-name">No. Kendaraan</InputLabel>
            <TextInput id="grid-last-name" class="1/2" type="text" placeholder="No. Kendaraan" required
                v-model="props.form.nopol[jumlahMobil]" />
            <p class="text-red text-xs italic text-gray-500">Mohon Di Isi</p>
        </div>
        <div class="sm:w-1/2 px-3">
            <InputLabel class="block text-black uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                for="grid-last-name">Tahun</InputLabel>

            <TextInput id="grid-first-name" type="number" placeholder="0000" required
                v-model="props.form.tahun[jumlahMobil]" />
            <p class="text-red text-xs italic text-gray-500">Mohon Di Isi</p>
        </div>
    </div>
    <div class="-mx-3 sm:flex justify-center w-full">
        <div class="md:w-1/2 px-3 mb-4 md:mb-0">
            <InputLabel class="block text-black uppercase tracking-wide text-grey-800 text-xs font-bold mb-2"
                for="grid-first-name">Nilai Sewa/Hari</InputLabel>
            <TextInput id="grid-first-name" type="text" placeholder="0000"
                v-model="props.form.nilaisewahari[jumlahMobil]" />
            <p class="text-red text-xs italic text-gray-500">
                Masukkan Hanya Angka
            </p>
        </div>
    </div>
    <hr class="my-2 h-px bg-gray-800 border-0 " />


</template>
