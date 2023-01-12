<script setup>
import { Link, Head, useForm } from '@inertiajs/inertia-vue3';
import { defineProps, ref , } from 'vue';
import AuthenticatedLayoutVue from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButtonVue from '@/Components/PrimaryButton.vue';
import TextInputVue from '@/Components/TextInput.vue';
import InputLabelVue from '@/Components/InputLabel.vue';
import ModalVue from '@/Components/Modal.vue';
import InputErrorVue from '@/Components/InputError.vue';
import SelectVue from '@/Components/Select.vue';
const data = defineProps({
    user: Object,
    role: Object,
    formdata: String,
})
const UserForm = useForm({
    nama: data.user == null ? '' : data.user.name,
    email: data.user == null ? '' : data.user.email,
    password: data.user == null ? '' : data.user.password,
    role: data.user == null ? '' : data.user.roles[0].name,
    can: data.user == null ? '' : data.user.role,
})

const role = ref(null);
function chageRole(event){
    UserForm.role = event.target.value
    console.log(UserForm.role)
}
function submit() {
    if (data.user == null) {
        UserForm.post(route('User.store'), {
            preserveState: true,
            onSuccess: () => {
                UserForm.reset();
            },
        })
    }else{
        UserForm.put(route('User.update', {id: data.user.id}), {
            preserveState: true,
            onSuccess: () => {
                UserForm.reset();
            },
        })
    }
}
</script>

<template>
    <AuthenticatedLayoutVue>

        <Head title="Form USER" />
        <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
            <ModalVue :show="true">
                <form @submit.prevent="submit">
                    <div class="flex flex-col -mb-8  p-8">
                        <div class="flex flex-col justify-center" v-show="data.formdata === 'false'" >
                            <InputLabelVue>Nama</InputLabelVue>
                            <TextInputVue v-model="UserForm.nama" placeholder="Name" />
                            <InputErrorVue :message="UserForm.errors.nama" />
                        </div>
                        <div class="flex flex-col justify-center" v-show="data.formdata === 'false'">
                            <InputLabelVue>email</InputLabelVue>
                            <TextInputVue v-model="UserForm.email" placeholder="email" />
                            <InputErrorVue :message="UserForm.errors.email" />
                        </div>
                        <div class="flex flex-col justify-center" v-show="data.formdata === 'true'">
                            <InputLabelVue>Password</InputLabelVue>
                            <TextInputVue v-model="UserForm.password" placeholder="..." />
                            <p v-if="data.user != null" class="text-xs text-gray-400">Kosongkan Jika Tidak Ingin Di Ubah</p>
                            <InputErrorVue :message="UserForm.errors.password" />
                        </div>
                        <div class="flex flex-col justify-center" v-show="data.formdata === 'false'">
                            <InputLabelVue>role</InputLabelVue>
                            <span>{{role}}</span>
                            <SelectVue  @change="chageRole($event)" v-model="UserForm.role">
                                <option value="--">----</option>
                                <option v-for="roles in data.role" :key="roles" :value="roles.name" > {{ roles.name }} </option>
                            </SelectVue>
                            <InputErrorVue :message="UserForm.errors.role" />
                        </div>
                    </div>
                    <div class="flex items-center justify-between px-8 py-4 bg-gray-50 border-t border-gray-100">
                        <Link :href="route('User.index')">
                        <PrimaryButtonVue class="bg-red-500" type="submit">Kembali</PrimaryButtonVue>
                        </Link>
                        <PrimaryButtonVue class="btn-indigo" type="submit">Simpan</PrimaryButtonVue>
                    </div>
                </form>
            </ModalVue>
        </div>
    </AuthenticatedLayoutVue>
</template>
