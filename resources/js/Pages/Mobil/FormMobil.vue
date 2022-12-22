
<script setup>
import { Head, useForm, Link } from '@inertiajs/inertia-vue3';
const form = useForm({
    unit: '',
    nopol: '',
    harga: '',
    foto1: '',
    foto2: '',
    foto3: '',
    foto4: '',
    spesifikasi: '',
    tahun: '',
})
const submit = () => {

    form.post(route('Mobil.store'), {
        forceFormData: true,
        onError: (error)=> console.log(error)

    });
};
const Error = form.errors;
</script>

<template>
    <AuthenticatedLayoutVue>

        <Head title="FormMobil" />
        <!-- component -->
        <div class="flex items-center justify-center md:px-12 py-3 ">
            <!-- Author: FormBold Team -->
            <!-- Learn More: https://formbold.com -->
            <div class="mx-auto w-full max-w-[550px] bg-white shadow-default-dark shadow-lg">
                <label v-for="error in Error" :key="error" for="unit" class=" block text-sm font-medium text-black">
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
                            spesifikasi
                        </label>
                        <input type="text" name="spesifikasi" id="spesifikasi" v-model="form.spesifikasi"
                            placeholder=".............."
                            class="w-full rounded-md border border-[#e0e0e0] bg-white text-sm font-medium text-black outline-none focus:border-default-dark focus:shadow-md" />
                    </div>
                    <div class=" mb-2">
                        <label for="nopol" class=" block text-sm font-medium text-black">
                            Nomor Polisi
                        </label>
                        <input type="text" name="nopol" id="nopol" v-model="form.nopol" placeholder=".............."
                            class="w-full rounded-md border border-[#e0e0e0] bg-white text-sm font-medium text-black outline-none focus:border-default-dark focus:shadow-md" />
                    </div>
                    <div class=" mb-2">
                        <label for="nopol" class=" block text-sm font-medium text-black">
                            Tahun
                        </label>
                        <input type="text" name="nopol" id="nopol" v-model="form.tahun" placeholder=".............."
                            class="w-full rounded-md border border-[#e0e0e0] bg-white text-sm font-medium text-black outline-none focus:border-default-dark focus:shadow-md" />
                    </div>
                    <div class="mb-2">
                        <label for="harga" class=" block text-sm font-medium text-black">
                            Harga Sewa
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
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-black">
                            Upload Foto Belakang
                        </label>

                        <div class="border border-gray-400 p-2 rounded-lg">
                            <input type="file" name="file" id="file" @change="form.foto2 = $event.target.files[0]" />

                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-black">
                            Upload Foto Samping Kanan
                        </label>

                        <div class="border border-gray-400 p-2 rounded-lg">
                            <input type="file" name="file" id="file" @input="form.foto3 = $event.target.files[0]" />

                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-black">
                            Upload Foto Samping Kiri
                        </label>

                        <div class="border border-gray-400 p-2 rounded-lg">
                            <input type="file" name="file" id="file" @input="form.foto4 = $event.target.files[0]" />
                        </div>
                    </div>
                    <progress v-if="form.progress" :value="form.progress.percentage"
                        class="bg-blue-600 h-2.5 rounded-full" max="100">
                        {{ form.progress.percentage }}%
                    </progress>
                    <div class="flex justify-around gap-2">
                        <Link :href="route('Mobil.index')"
                            class="hover:shadow-form w-full rounded-md bg-default-red py-3 px-8 text-center text-base font-semibold text-white outline-none">
                        Kembali
                        </Link>
                        <button type="submit"
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
