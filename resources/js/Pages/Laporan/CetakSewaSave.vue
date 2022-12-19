<script setup>
import { defineProps, ref, onMounted } from 'vue';
import AuthenticatedLayoutVue from '@/Layouts/AuthenticatedLayout.vue';
import { Link , usePage} from '@inertiajs/inertia-vue3';
import PrimaryButtonVue from '@/Components/PrimaryButton.vue';
import  TextInput from '@/Components/TextInput.vue'
const pdfFile = defineProps({
    pdf: {
        type: String,
        default: () => ({})
    }
})
const myinput = window.location.origin +'/storage/'+ pdfFile.pdf;
const input = ref(null)

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
</script>
<template>
    <AuthenticatedLayoutVue>
        <div class="flex">
            <TextInput class="max-w-md" v-on:focus="$event.target.select()" ref="input" readonly :value="myinput" />
        <PrimaryButtonVue @click="copy">Copy Link</PrimaryButtonVue>

        </div>
        <iframe :src="`/storage/${pdf}`" class="w-full h-screen"></iframe>

    </AuthenticatedLayoutVue>
</template>
