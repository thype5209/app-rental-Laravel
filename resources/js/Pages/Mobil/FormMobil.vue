
<script setup>
import { Head, useForm } from '@inertiajs/inertia-vue3';
import { defineProps } from 'vue';

const form = useForm({
    unit: '',
    nopol: '',
    harga: '',
    foto1: null,
    foto2: null,
    foto3: null,
    foto4: null,
})
const submit = () => {
    form.post(route('Mobil.store'), {
        forceFormData: true,
        onFinish: () => form.reset('unit'),

    });
};
</script>

<template>
    <AuthenticatedLayoutVue>

        <Head title="FormMobil" />
        <!-- component -->
        <div class="flex items-center justify-center md:px-12 py-3 ">
            <!-- Author: FormBold Team -->
            <!-- Learn More: https://formbold.com -->
            <div class="mx-auto w-full max-w-[550px] bg-white shadow-default-dark shadow-lg">
                <form @submit.prevent="submit" class="py-6 px-9" method="POST">
                    <div class="mb-5">
                        <label for="unit" class="mb-3 block text-base font-medium text-[#07074D]">
                            Unit Mobil
                        </label>
                        <input type="text" name="unit" id="unit" v-model="form.unit" placeholder=".............."
                            class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-default-dark focus:shadow-md" />
                    </div>
                    <div class="mb-5">
                        <label for="nopol" class="mb-3 block text-base font-medium text-[#07074D]">
                            Nomor Polisi
                        </label>
                        <input type="text" name="nopol" id="nopol" v-model="form.nopol" placeholder=".............."
                            class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-default-dark focus:shadow-md" />
                    </div>
                    <div class="mb-5">
                        <label for="harga" class="mb-3 block text-base font-medium text-[#07074D]">
                            Harga
                        </label>
                        <input type="number" name="harga" id="harga" v-model="form.harga" placeholder=".............."
                            class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-default-dark focus:shadow-md" />
                    </div>

                    <div class="mb-6 pt-4">
                        <label class="mb-5 block text-xl font-semibold text-[#07074D]">
                            Upload Foto Depan
                        </label>

                        <div class="mb-8">
                            <input type="file" name="file" id="file" @input="form.foto1 = $event.target.files[0]"  />
                        </div>
                    </div>
                    <div class="mb-6 pt-4">
                        <label class="mb-5 block text-xl font-semibold text-[#07074D]">
                            Upload Foto Belakang
                        </label>

                        <div class="mb-8">
                            <input type="file" name="file" id="file"   @change="form.foto2 = $event.target.files[0]"/>

                        </div>
                    </div>
                    <div class="mb-6 pt-4">
                        <label class="mb-5 block text-xl font-semibold text-[#07074D]">
                            Upload Foto Samping Kanan
                        </label>

                        <div class="mb-8">
                            <input type="file" name="file" id="file"  @input="form.foto3 = $event.target.files[0]" />

                        </div>
                    </div>
                    <div class="mb-6 pt-4">
                        <label class="mb-5 block text-xl font-semibold text-[#07074D]">
                            Upload Foto Samping Kiri
                        </label>

                        <div class="mb-8">
                            <input type="file" name="file" id="file"  @input="form.foto4 = $event.target.files[0]"/>
                        </div>
                    </div>
                    <progress v-if="form.progress" :value="form.progress.percentage" class="bg-blue-600 h-2.5 rounded-full" max="100">
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
    name: "FormMobil.vue",
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
