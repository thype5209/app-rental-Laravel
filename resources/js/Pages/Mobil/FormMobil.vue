<template>
    <AuthenticatedLayoutVue>
        <!-- component -->
        <div class="flex items-center justify-center md:px-12 py-3 ">
            <!-- Author: FormBold Team -->
            <!-- Learn More: https://formbold.com -->
            <div class="mx-auto w-full max-w-[550px] bg-white shadow-default-dark shadow-lg">
                <form class="py-6 px-9" action="https://formbold.com/s/FORM_ID" method="POST">
                    <div class="mb-5">
                        <label for="unit" class="mb-3 block text-base font-medium text-[#07074D]">
                            Unit Mobil
                        </label>
                        <input type="text" name="unit" id="unit" v-model="unit" placeholder=".............."
                            class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-default-dark focus:shadow-md" />
                    </div>
                    <div class="mb-5">
                        <label for="nopol" class="mb-3 block text-base font-medium text-[#07074D]">
                            Nomor Polisi
                        </label>
                        <input type="text" name="nopol" id="nopol" v-model="nopol" placeholder=".............."
                            class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-default-dark focus:shadow-md" />
                    </div>

                    <div class="mb-6 pt-4">
                        <label class="mb-5 block text-xl font-semibold text-[#07074D]">
                            Upload Foto Depan
                        </label>

                        <div class="mb-8">
                            <input type="file" name="file" id="file" @change="uploadFile" class="sr-only" />
                            <label for="file"
                                class="relative flex h-max items-center justify-center rounded-md border border-dashed border-[#e0e0e0] text-center">
                                <div>
                                    <span class="mb-2 block text-xl font-semibold text-[#07074D]">
                                        Drop files here
                                    </span>
                                    <span class="mb-2 block text-base font-medium text-[#6B7280]">
                                        Or
                                    </span>
                                    <span
                                        class="inline-flex rounded border border-[#e0e0e0] py-2 px-7 text-base font-medium text-[#07074D]">
                                        Browse
                                    </span>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="mb-6 pt-4">
                        <label class="mb-5 block text-xl font-semibold text-[#07074D]">
                            Upload Foto Belakang
                        </label>

                        <div class="mb-8">
                            <input type="file" name="file" id="file" class="sr-only" />
                            <label for="file"
                                class="relative flex h-max items-center justify-center rounded-md border border-dashed border-[#e0e0e0] text-center">
                                <div>
                                    <span class="mb-2 block text-xl font-semibold text-[#07074D]">
                                        Drop files here
                                    </span>
                                    <span class="mb-2 block text-base font-medium text-[#6B7280]">
                                        Or
                                    </span>
                                    <span
                                        class="inline-flex rounded border border-[#e0e0e0] py-2 px-7 text-base font-medium text-[#07074D]">
                                        Browse
                                    </span>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="mb-6 pt-4">
                        <label class="mb-5 block text-xl font-semibold text-[#07074D]">
                            Upload Foto Samping Kanan
                        </label>

                        <div class="mb-8">
                            <input type="file" name="file" id="file" class="sr-only" />
                            <label for="file"
                                class="relative flex h-max items-center justify-center rounded-md border border-dashed border-[#e0e0e0] text-center">
                                <div>
                                    <span class="mb-2 block text-xl font-semibold text-[#07074D]">
                                        Drop files here
                                    </span>
                                    <span class="mb-2 block text-base font-medium text-[#6B7280]">
                                        Or
                                    </span>
                                    <span
                                        class="inline-flex rounded border border-[#e0e0e0] py-2 px-7 text-base font-medium text-[#07074D]">
                                        Browse
                                    </span>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="mb-6 pt-4">
                        <label class="mb-5 block text-xl font-semibold text-[#07074D]">
                            Upload Foto Samping Kiri
                        </label>

                        <div class="mb-8">
                            <input type="file" name="file" id="file" class="sr-only" />
                            <label for="file"
                                class="relative flex h-max items-center justify-center rounded-md border border-dashed border-[#e0e0e0] text-center">
                                <div>
                                    <span class="mb-2 block text-xl font-semibold text-[#07074D]">
                                        Drop files here
                                    </span>
                                    <span class="mb-2 block text-base font-medium text-[#6B7280]">
                                        Or
                                    </span>
                                    <span
                                        class="inline-flex rounded border border-[#e0e0e0] py-2 px-7 text-base font-medium text-[#07074D]">
                                        Browse
                                    </span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div>
                        <button
                            class="hover:shadow-form w-full rounded-md bg-default-dark py-3 px-8 text-center text-base font-semibold text-white outline-none">
                            Send File
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
            unit: '',
            nopol: '',
            foto1: '',
            foto2: '',
            foto3: '',
            foto4: '',
        }
    },
    methods: {
        uploadFile() {
        this.foto1 = this.$refs.file.files[0];
      },
    
    }
}
</script>