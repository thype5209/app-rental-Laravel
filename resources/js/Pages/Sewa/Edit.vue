

<script setup>
import { ref, watch, defineProps } from 'vue';
import { Link, useForm, Head } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import Select from '@/Components/Select.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue'
const props = defineProps({
    sewa: {
        type: Object,
        default: () => ({}),
    }
})
const rupiah = (number) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR"
    }).format(number);
}
const Form = useForm({
    jenis_sewa: props.sewa.jenis_sewa,
    nik: props.sewa.nik,
    unit: explode(props.sewa.unit),
    nopol: explode(props.sewa.nopol),
    tahun: explode(props.sewa.tahun),
    harga: explode(props.sewa.harga),
    tujuan: props.sewa.tujuan,
    jaminan: props.sewa.jaminan,
    sisa: props.sewa.sisa,
    panjar: props.sewa.panjar,
    denda: props.sewa.denda,
    list_pengiriman: props.sewa.list_pengiriman,
    metode_bayar: props.sewa.metode_bayar,
    total: props.sewa.total,
    sopir_id: props.sewa.sopir_id,
    tgl_sewa: props.sewa.waktusewa.tgl_sewa,
    jam_sewa: props.sewa.waktusewa.jam_sewa,
    tgl_kembali: props.sewa.waktusewa.tgl_kembali,
    jam_kembali: props.sewa.waktusewa.jam_kembali,
    lama_sewa: props.sewa.waktusewa.lama_sewa,
    telat: props.sewa.waktusewa.telat,
})

function explode(array = ''){
    var split = array.split(/\,|\./);
    return split;
}
explode('matras,fan.3')

function kembali() {
    window.history.back();
}

function submit(){
    Form.put(route('Sewa.update', {id: props.sewa.id}) , {
    })
}
</script>

<template>
    <AuthenticatedLayout>

        <Head title="Edit Sewa" />
        <div class="md:container mx-auto px-10 md:py-5 py-2 border rounded-sm">
            <form @submit.prevent="submit" action="#">
                <table class="table table-auto w-full">
                    <tr class=" border-bottom border-b border-gray-400">
                        <td class="py-2" colspan="2">
                            <Link @click="kembali">
                            <PrimaryButton class="bg-red-500 hover:bg-red-600">Kembali</PrimaryButton>
                            </Link>
                        </td>
                    </tr>
                    <tr class=" border-bottom border-b border-gray-400">
                        <td class="py-2">
                            <InputLabel class="capitalize font-semibold">Jenis Sewa</InputLabel>
                        </td>
                        <td class="py-2">
                            <Select v-model="Form.jenis_sewa" placeholder="jenis Sewa">
                                <option value="Lepas">Lepas Kunci</option>
                                <option value="Kunci">Dengan Driver</option>
                            </Select>
                        </td>
                    </tr>
                    <tr class=" border-bottom border-b border-gray-400">
                        <td class="py-2">
                            <InputLabel class="capitalize font-semibold">Nik Penyewa</InputLabel>
                        </td>
                        <td class="py-2">
                            <TextInput type="text" v-model="Form.nik" placeholder="Nik Penyewa" />
                            <InputError :message="Form.errors.nik" />

                        </td>
                    </tr>

                </table>
                <table class="table table-auto w-full" v-for="(item, index) in Form.unit.length" :key="item" :index="index">
                    <tr class=" border-bottom border-b border-gray-400">
                        <td class="py-2">
                            <InputLabel class="capitalize font-semibold">No. Polisi {{item}}</InputLabel>
                        </td>
                        <td class="py-2">
                            <InputLabel class="capitalize font-semibold">Unit Mobil {{item}}</InputLabel>
                        </td>
                        <td class="py-2">
                            <InputLabel class="capitalize font-semibold">tahun Mobil {{item}}</InputLabel>
                        </td>
                        <td class="py-2">
                            <InputLabel class="capitalize font-semibold">Harga Sewa/Hari {{item}}</InputLabel>
                        </td>
                    </tr>
                    <tr class=" border-bottom border-b border-gray-400">

                        <td class="py-2">
                            <TextInput type="text" v-model="Form.unit[index]" placeholder="Unit Mobil" />
                            <InputError :message="Form.errors.unit" />

                        </td>
                        <td class="py-2">
                            <TextInput type="text" v-model="Form.nopol[index]" placeholder="No. Polisi" />
                            <InputError :message="Form.errors.nopol" />
                        </td>
                        <td class="py-2">
                            <TextInput type="text" v-model="Form.tahun[index]" placeholder="tahun Mobil" />
                            <InputError :message="Form.errors.tahun" />
                        </td>

                        <td class="py-2">
                            <TextInput type="text" v-model="Form.harga[index]" placeholder="Harga Sewa" />
                            <InputError :message="Form.errors.harga" />

                        </td>
                    </tr>

                </table>
                <table class="table table-auto w-full">
                    <tr class=" border-bottom border-b border-gray-400">
                        <td class="py-2">
                            <InputLabel class="capitalize font-semibold">Sopir </InputLabel>
                        </td>
                        <td class="py-2">
                            <TextInput type="text" v-model="Form.sopir_id" placeholder="Nama Sopir" />
                            <InputError :message="Form.errors.sopir_id" />
                        </td>
                    </tr>
                    <tr class=" border-bottom border-b border-gray-400">
                        <td class="py-2">
                            <InputLabel class="capitalize font-semibold">Tujuan </InputLabel>
                        </td>
                        <td class="py-2">
                            <TextInput type="text" v-model="Form.tujuan" placeholder="Tujuan" />
                            <InputError :message="Form.errors.tujuan" />

                        </td>
                    </tr>
                    <tr class=" border-bottom border-b border-gray-400">
                        <td class="py-2">
                            <InputLabel class="capitalize font-semibold">Jaminan </InputLabel>
                        </td>
                        <td class="py-2">
                            <TextInput type="text" v-model="Form.jaminan" placeholder="Jaminan" />
                            <InputError :message="Form.errors.jaminan" />

                        </td>
                    </tr>
                    <tr class=" border-bottom border-b border-gray-400">
                        <td class="py-2">
                            <InputLabel class="capitalize font-semibold">Tanggal Sewa </InputLabel>
                        </td>
                        <td class="py-2">
                            <TextInput type="date" v-model="Form.tgl_sewa" placeholder="Tanggal Sewa" />
                            <InputError :message="Form.errors.tgl_sewa" />
                        </td>
                    </tr>
                    <tr class=" border-bottom border-b border-gray-400">
                        <td class="py-2">
                            <InputLabel class="capitalize font-semibold">jam Sewa </InputLabel>
                        </td>
                        <td class="py-2">
                            <TextInput type="time" v-model="Form.jam_sewa" placeholder="jam Sewa" />
                            <InputError :message="Form.errors.jam_sewa" />
                        </td>
                    </tr>
                    <tr class=" border-bottom border-b border-gray-400">
                        <td class="py-2">
                            <InputLabel class="capitalize font-semibold">Tanggal kembali </InputLabel>
                        </td>
                        <td class="py-2">
                            <TextInput type="date" v-model="Form.tgl_kembali" placeholder="Tanggal Kembali" />
                            <InputError :message="Form.errors.tgl_kembali" />
                        </td>
                    </tr>
                    <tr class=" border-bottom border-b border-gray-400">
                        <td class="py-2">
                            <InputLabel class="capitalize font-semibold">Jam kembali </InputLabel>
                        </td>
                        <td class="py-2">
                            <TextInput type="time" v-model="Form.jam_kembali" placeholder="Jam Kembali" />
                            <InputError :message="Form.errors.jam_kembali" />
                        </td>
                    </tr>
                    <tr class=" border-bottom border-b border-gray-400">
                        <td class="py-2">
                            <InputLabel class="capitalize font-semibold">Lama Sewa </InputLabel>
                        </td>
                        <td class="py-2">
                            <TextInput type="number" v-model="Form.lama_sewa" placeholder="Lama Sewa" />
                            <InputError :message="Form.errors.lama_sewa" />
                        </td>
                    </tr>
                    <tr class=" border-bottom border-b border-gray-400">
                        <td class="py-2">
                            <InputLabel class="capitalize font-semibold">Jumlah Telat/Jam </InputLabel>
                        </td>
                        <td class="py-2">
                            <TextInput type="number" v-model="Form.telat" placeholder="00 jam" />
                            <InputError :message="Form.errors.telat" />
                        </td>
                    </tr>
                    <tr class=" border-bottom border-b border-gray-400">
                        <td class="py-2">
                            <InputLabel class="capitalize font-semibold">denda </InputLabel>
                        </td>
                        <td class="py-2">
                            <TextInput type="text" v-model="Form.denda" placeholder="denda" />
                            <InputError :message="Form.errors.denda" />
                        </td>
                    </tr>
                    <tr class=" border-bottom border-b border-gray-400">
                        <td class="py-2">
                            <InputLabel class="capitalize font-semibold">sisa Pembayaran </InputLabel>
                        </td>
                        <td class="py-2">
                            <TextInput type="text" v-model="Form.sisa" placeholder="sisa Pembayaran" />
                            <InputError :message="Form.errors.sisa" />
                        </td>
                    </tr>
                    <tr class=" border-bottom border-b border-gray-400">
                        <td class="py-2">
                            <InputLabel class="capitalize font-semibold"> Panjar </InputLabel>
                        </td>
                        <td class="py-2">
                            <TextInput type="text" v-model="Form.panjar" placeholder=" Panjar" />
                            <InputError :message="Form.errors.panjar" />
                        </td>
                    </tr>
                    <tr class=" border-bottom border-b border-gray-400">
                        <td class="py-2">
                            <InputLabel class="capitalize font-semibold"> Sub Total </InputLabel>
                        </td>
                        <td class="py-2">
                            <TextInput type="text" v-model="Form.total" placeholder=" Sub Total" />
                            <InputError :message="Form.errors.total" />
                        </td>
                    </tr>
                    <tr class=" border-bottom border-b border-gray-400">
                        <td class="py-2">
                            <InputLabel class="capitalize font-semibold"> Metode Pembayaran </InputLabel>
                        </td>
                        <td class="py-2">
                            <ul
                                class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 ">
                                <li
                                    class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                    <div class="flex items-center pl-3">
                                        <input id="horizontal-list-radio-license" type="radio"
                                            v-model="Form.metode_bayar" chec value="Transfer"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 ">
                                        <label for="horizontal-list-radio-license"
                                            class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Transfer</label>
                                    </div>
                                </li>
                                <li
                                    class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                    <div class="flex items-center pl-3">
                                        <input id="horizontal-list-radio-id" type="radio" v-model="Form.metode_bayar"
                                            value="Cash"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 ">
                                        <label for="horizontal-list-radio-id"
                                            class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Cash</label>
                                    </div>
                                </li>
                            </ul>
                            <InputError :message="Form.errors.metode_bayar" />

                        </td>
                    </tr>
                    <tr class=" border-bottom border-b border-gray-400">
                        <td class="py-2">
                            <InputLabel class="capitalize font-semibold">list pengiriman </InputLabel>
                        </td>
                        <td class="py-2">
                            <TextInput type="text" v-model="Form.list_pengiriman" placeholder="list pengiriman" />
                            <InputError :message="Form.errors.list_pengiriman" />

                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class=" text-center">
                            <PrimaryButton type="submit" class=" w-full text-center flex items-center justify-center" >Simpan</PrimaryButton>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

