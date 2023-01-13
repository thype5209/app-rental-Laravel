<template>
    <div>

    </div>
</template>

<script setup>
import { defineProps } from 'vue';

const Form = defineProps(['Form', 'Sopir'])
// Fungsi Cari Mobil Dengan Select ID
function GetSopir(event) {
    axios
        .get("/Sopir/GetSopir/" + event.target.value)
        .then(function (response) {
            const mobil = response.data;
            Form.nama_sopir = mobil.nama;
            Form.sopir_nik = mobil.nik;
            Form.sopir_no_hp = mobil.no_hp;
            Form.sopir_alamat = mobil.alamat;
            Form.mobil_id = mobil.id;
        })
        .catch(errors => console.log(errors));
}

</script>
