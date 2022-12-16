
<script setup>
import { Head, useForm } from '@inertiajs/inertia-vue3';
import { defineProps } from 'vue';

var mobil = null;
const data = defineProps({
    mobil: {
        type: Object,
        default: () => ({})
    }
})
mobil = data.mobil.id;
const edit =  true;
const form = useForm({
    unit: data.mobil.unit,
    nopol: data.mobil.nopol,
    harga: data.mobil.harga,
    foto1: data.mobil.foto1,
    foto2: data.mobil.foto2,
    foto3: data.mobil.foto3,
    foto4: data.mobil.foto4,
})
const submit = () => {
    form.put(route('Mobil.update', data.mobil.id));
};
</script>

<template>
    <AuthenticatedLayoutVue>

        <Head title="Edit Mobil" />
        <!-- component -->

        <div class="flex items-center justify-center md:px-12 py-3 ">
            <!-- Author: FormBold Team -->
            <!-- Learn More: https://formbold.com -->
            <div class="mx-auto w-full max-w-[550px] bg-white shadow-default-dark shadow-lg">
                <label v-for="error in form.errors" :key="error" for="unit" class=" block text-sm font-medium text-black">
                    {{ error }}
                </label>
                <form @submit.prevent="submit" class="py-6 px-9" method="POST">
                    <div class=" mb-2">
                        <label for="unit" class=" block text-sm font-medium text-black">
                            Unit Mobil
                        </label>
                        <input type="text" name="unit" id="unit" v-model="form.unit" placeholder=".............."
                            class="w-full rounded-md border border-[#e0e0e0] bg-white text-sm font-medium text-black outline-none focus:border-default-dark focus:shadow-md" />
                    </div>
                    <div class=" mb-2">
                        <label for="nopol" class=" block text-sm font-medium text-black">
                            Nomor Polisi
                        </label>
                        <input type="text" name="nopol" id="nopol" v-model="form.nopol" placeholder=".............."
                            class="w-full rounded-md border border-[#e0e0e0] bg-white text-sm font-medium text-black outline-none focus:border-default-dark focus:shadow-md" />
                    </div>
                    <div class="mb-2">
                        <label for="harga" class=" block text-sm font-medium text-black">
                            Harga
                        </label>
                        <input type="number" name="harga" id="harga" v-model="form.harga" placeholder=".............."
                            class="w-full rounded-md border border-[#e0e0e0] bg-white text-sm font-medium text-black outline-none focus:border-default-dark focus:shadow-md" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-black">
                            Upload Foto Depan
                        </label>

                        <div class="border border-gray-400 p-2 rounded-lg">
                            <input type="file" name="file" id="file" @input="form.foto1 = $event.target.files[0]" />
                        </div>
                        <label v-if="edit == true" class=" mb-4 block text-xs font-semibold text-gray-500">
                            Kosongkan Jika tidak ingin di Edit
                        </label>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-black">
                            Upload Foto Belakang
                        </label>

                        <div class="border border-gray-400 p-2 rounded-lg">
                            <input type="file" name="file" id="file" @change="form.foto2 = $event.target.files[0]" />

                        </div>
                        <label v-if="edit == true" class=" mb-4 block text-xs font-semibold text-gray-500">
                            Kosongkan Jika tidak ingin di Edit
                        </label>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-black">
                            Upload Foto Samping Kanan
                        </label>

                        <div class="border border-gray-400 p-2 rounded-lg">
                            <input type="file" name="file" id="file" @input="form.foto3 = $event.target.files[0]" />

                        </div>
                        <label v-if="edit == true" class=" mb-4 block text-xs font-semibold text-gray-500">
                            Kosongkan Jika tidak ingin di Edit
                        </label>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-black">
                            Upload Foto Samping Kiri
                        </label>

                        <div class="border border-gray-400 p-2 rounded-lg">
                            <input type="file" name="file" id="file" @input="form.foto4 = $event.target.files[0]" />
                        </div>
                        <label v-if="edit == true" class=" mb-4 block text-xs font-semibold text-gray-500">
                            Kosongkan Jika tidak ingin di Edit
                        </label>
                    </div>
                    <progress v-if="form.progress" :value="form.progress.percentage"
                        class="bg-blue-600 h-2.5 rounded-full" max="100">
                        {{ form.progress.percentage }}%
                    </progress>
                    <div>
                        <button
                            class="hover:shadow-form w-full rounded-md bg-default-dark py-3 px-8 text-center text-base font-semibold text-white outline-none">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayoutVue>
</template>

<script>
import AuthenticatedLayoutVue from '@/Layouts/AuthenticatedLayout.vue';
export default {
    name: "EditMobil.vue",
    components: {
        AuthenticatedLayoutVue
    },
    data() {
        return {

        }
    },
    methods: {
        uploadFile() {
            this.foto1 = this.$refs.file.files[0];
        },

    }
}
</script>
