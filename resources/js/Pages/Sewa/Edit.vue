

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

const FotoKTP = ref(null)
const Form = useForm({
    jenis_sewa: props.sewa.jenis_sewa,
    foto_ktp: null,
    nik: props.sewa.nik,
    nama: props.sewa.pengguna.nama,
    no_hp: props.sewa.pengguna.no_hp,
    no_hp_lain: props.sewa.pengguna.no_hp_lain,
    alamat: props.sewa.pengguna.alamat,
    pekerjaan: props.sewa.pengguna.pekerjaan,
    tempat_lahir: props.sewa.pengguna.tempat_lahir,
    tgl_lahir: props.sewa.pengguna.tgl_lahir,
    unit: explode(props.sewa.unit),
    nopol: explode(props.sewa.nopol),
    tahun: explode(props.sewa.tahun),
    nilaisewahari: explode(props.sewa.harga),
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
    lunas: props.sewa.status_bayar,
    ket_syarat: props.sewa.ket_syarat,
    tgl_file: props.sewa.tgl_file,
    nilai_denda: props.sewa.nilai_denda,
})

function explode(array = '') {
    var split = array.split(/\,|\./);
    return split;
}
explode('matras,fan.3')

function kembali() {
    window.history.back();
}

function submit() {
    Form.put(route('Laporan.UpdateSewa', { id: props.sewa.id }), {
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
                            <InputLabel class="capitalize font-semibold">foto_ktp Penyewa</InputLabel>
                        </td>
                        <td class="py-2">
                            <TextInput type="file" @input="Form.foto_ktp = $event.target.files[0]"
                                placeholder="foto_ktp Penyewa" />
                            <InputError :message="Form.errors.foto_ktp" />
                        </td>
                    </tr>
                    <tr class=" border-bottom border-b border-gray-400">
                        <td class="py-2">
                            <InputLabel class="capitalize font-semibold">nik Penyewa</InputLabel>
                        </td>
                        <td class="py-2">
                            <TextInput type="text" v-model="Form.nik" placeholder="nik Penyewa" />
                            <InputError :message="Form.errors.nik" />
                        </td>
                    </tr>
                    <tr class=" border-bottom border-b border-gray-400">
                        <td class="py-2">
                            <InputLabel class="capitalize font-semibold">nama Penyewa</InputLabel>
                        </td>
                        <td class="py-2">
                            <TextInput type="text" v-model="Form.nama" placeholder="nama Penyewa" />
                            <InputError :message="Form.errors.nama" />
                        </td>
                    </tr>
                    <tr class=" border-bottom border-b border-gray-400">
                        <td class="py-2">
                            <InputLabel class="capitalize font-semibold">Nomor Penyewa</InputLabel>
                        </td>
                        <td class="py-2">
                            <TextInput type="text" v-model="Form.no_hp" placeholder="Nomor Penyewa" />
                            <InputError :message="Form.errors.no_hp" />
                        </td>
                    </tr>
                    <tr class=" border-bottom border-b border-gray-400">
                        <td class="py-2">
                            <InputLabel class="capitalize font-semibold">Nomor HP lain Penyewa</InputLabel>
                        </td>
                        <td class="py-2">
                            <TextInput type="text" v-model="Form.no_hp_lain" placeholder="Nomor HP lain Penyewa" />
                            <InputError :message="Form.errors.no_hp_lain" />
                        </td>
                    </tr>
                    <tr class=" border-bottom border-b border-gray-400">
                        <td class="py-2">
                            <InputLabel class="capitalize font-semibold">alamat Penyewa</InputLabel>
                        </td>
                        <td class="py-2">
                            <TextInput type="text" v-model="Form.alamat" placeholder="alamat Penyewa" />
                            <InputError :message="Form.errors.alamat" />
                        </td>
                    </tr>
                    <tr class=" border-bottom border-b border-gray-400">
                        <td class="py-2">
                            <InputLabel class="capitalize font-semibold">pekerjaan Penyewa</InputLabel>
                        </td>
                        <td class="py-2">
                            <TextInput type="text" v-model="Form.pekerjaan" placeholder="pekerjaan Penyewa" />
                            <InputError :message="Form.errors.pekerjaan" />
                        </td>
                    </tr>
                    <tr class=" border-bottom border-b border-gray-400">
                        <td class="py-2">
                            <InputLabel class="capitalize font-semibold">Tempat Lahir Penyewa</InputLabel>
                        </td>
                        <td class="py-2">
                            <TextInput type="text" v-model="Form.tempat_lahir" placeholder="Tempat lahir Penyewa" />
                            <InputError :message="Form.errors.tempat_lahir" />
                        </td>
                    </tr>
                    <tr class=" border-bottom border-b border-gray-400">
                        <td class="py-2">
                            <InputLabel class="capitalize font-semibold">Tanggal Lahir Penyewa</InputLabel>
                        </td>
                        <td class="py-2">
                            <TextInput type="date" v-model="Form.tgl_lahir" placeholder="Tanggal Lahir Penyewa" />
                            <InputError :message="Form.errors.tgl_lahir" />
                        </td>
                    </tr>

                </table>
                <table class="table table-auto w-full" v-for="(item, index) in Form.unit.length" :key="item"
                    :index="index">
                    <tr class=" border-bottom border-b border-gray-400">
                        <td class="py-2">
                            <InputLabel class="capitalize font-semibold">No. Polisi {{ item }}</InputLabel>
                        </td>
                        <td class="py-2">
                            <InputLabel class="capitalize font-semibold">Unit Mobil {{ item }}</InputLabel>
                        </td>
                        <td class="py-2">
                            <InputLabel class="capitalize font-semibold">tahun Mobil {{ item }}</InputLabel>
                        </td>
                        <td class="py-2">
                            <InputLabel class="capitalize font-semibold">Harga Sewa/Hari {{ item }}</InputLabel>
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
                            <TextInput type="text" v-model="Form.nilaisewahari[index]" placeholder="Harga Sewa" />
                            <InputError :message="Form.errors.nilaisewahari" />

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
                            <TextInput type="number" v-model="Form.denda" placeholder="denda" />
                            <InputError :message="Form.errors.denda" />
                        </td>
                    </tr>
                    <tr class=" border-bottom border-b border-gray-400">
                        <td class="py-2">
                            <InputLabel class="capitalize font-semibold">sisa Pembayaran </InputLabel>
                        </td>
                        <td class="py-2">
                            <TextInput type="number" v-model="Form.sisa" placeholder="sisa Pembayaran" />
                            <InputError :message="Form.errors.sisa" />
                        </td>
                    </tr>
                    <tr class=" border-bottom border-b border-gray-400">
                        <td class="py-2">
                            <InputLabel class="capitalize font-semibold"> Panjar </InputLabel>
                        </td>
                        <td class="py-2">
                            <TextInput type="number" v-model="Form.panjar" placeholder=" Panjar" />
                            <InputError :message="Form.errors.panjar" />
                        </td>
                    </tr>
                    <tr class=" border-bottom border-b border-gray-400">
                        <td class="py-2">
                            <InputLabel class="capitalize font-semibold">Nilai Denda </InputLabel>
                        </td>
                        <td class="py-2">
                            <TextInput type="number" v-model="Form.nilai_denda" placeholder="Nilai Denda" />
                            <InputError :message="Form.errors.nilai_denda" />
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
                            <InputLabel class="capitalize font-semibold"> Metode Pembayaran </InputLabel>
                        </td>
                        <td class="py-2">
                            <ul
                                class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 ">
                                <li
                                    class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                    <div class="flex items-center pl-3">
                                        <input id="horizontal-list-radio-license" type="radio" v-model="Form.lunas" chec
                                            value="1"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 ">
                                        <label for="horizontal-list-radio-license"
                                            class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Lunas</label>
                                    </div>
                                </li>
                                <li
                                    class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                    <div class="flex items-center pl-3">
                                        <input id="horizontal-list-radio-id" type="radio" v-model="Form.lunas" value="3"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 ">
                                        <label for="horizontal-list-radio-id"
                                            class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Belum
                                            Lunas</label>
                                    </div>
                                </li>
                            </ul>
                            <InputError :message="Form.errors.lunas" />

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
                        <td colspan="2">
                                  <!-- Keterangan Dan Syarat Sewa -->
                    <div class="inline-flex justify-center items-center w-full">
                        <hr class="my-1 w-full h-1 bg-gray-200 rounded border-0 " />
                        <div class="absolute left-1/2 px-4 bg-white -translate-x-1/2 ">Keterangan Dan Syarat Sewa</div>
                    </div>
                    <div
                        class="bg-gray-200 shadow-md rounded md:px-8 pt-6 mb-4 flex justify-center flex-col my-2 w-full">
                        <div class="w-full px-3 mb-5">
                            <ckeditor :editor="editor" v-model="Form.ket_syarat" :config="editorConfig"></ckeditor>
                        </div>
                        <p class=" font-semibold text-gray-900  text-sm lowercase">Isi Kolom Untuk Tanggal File</p>
                        <TextInput type="text" v-model="Form.tgl_file" placeholder="Isikan Keterangan Pengambilan"
                            required />
                        <p v-if="Form.errors.tgl_file" class="text-red text-xs italic text-red-500">Mohon Di Isi</p>
                        <p v-else class="text-red text-xs italic text-red-500">contoh: Makassar, 12 Januari 2023</p>

                    </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class=" text-center">
                            <PrimaryButton type="submit" class=" w-full text-center flex items-center justify-center">
                                Simpan</PrimaryButton>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
<script>
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import CKEditor from '@ckeditor/ckeditor5-vue';

export default {
    name: "FormPinjamVue",
    components: {
        ckeditor: CKEditor.component,
    },
    data() {
        return {
            editor: ClassicEditor,

            editorConfig: {
                // toolbar: ['bold', 'italic', '|', 'NumberedList', 'BulletedList',
                // ],

            }
        };
    },
};
</script>
