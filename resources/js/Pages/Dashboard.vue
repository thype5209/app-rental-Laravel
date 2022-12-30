<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,Link } from '@inertiajs/inertia-vue3';
import { defineProps, ref, watch } from 'vue';

const data = defineProps({
    penyewa: Number,
    totalPendapatan: Number,
    mobilSewa: Number,
    SewaTelat: Object,
    mobil: {
        type: Object,
        default: () => ({})
    },
    sewaTerbaru: Object,
})
function mapArray() {
    let nilaiMap = data.mobil.data;
    var hasil = nilaiMap.reduce((unit, obj) => {
        if (!unit[obj.unit]) {
            unit[obj.unit] = []
        }
        unit[obj.unit].push(obj);
        return unit;
    }, {})
    return hasil;
}
const MapMobil = mapArray();
function parseDate(date) {
    var t = new Date(date)
    return t.getDate();
}
function parseDateNow() {
    const sewa = data.sewaTerbaru.data;
    const dateToday = new Date();
    const dateYesterday = new Date().setDate(dateToday.getDate() - 1);
    var arrToday = [];
    for (let i = 0; i < sewa.length; i++) {
        arrToday.push(sewa[i]);
    }
    let filterDate = arrToday.filter(obj => parseDate(obj.created_at) === dateToday.getDate())
    let filterDateYesterday = arrToday.filter(obj => parseDate(obj.created_at) === dateYesterday)
    const SewaToday = {
        'today': filterDate,
        'yesterday': filterDateYesterday,
    };

    return SewaToday;
}
var yesterday =
console.log(parseDateNow())
let forDate = parseDateNow();
</script>

<template>

    <Head title="Dashboard" />
    <AuthenticatedLayout>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 p-4 gap-4">
            <div
                class="bg-default-dark dark:bg-gray-800 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-blue-600 dark:border-gray-600 text-white font-medium group">
                <div
                    class="flex justify-center items-center w-14 h-14 bg-white rounded-full transition-all duration-300 transform group-hover:rotate-12">
                    <svg width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="stroke-current text-default-dark dark:text-gray-800 transform transition-transform duration-500 ease-in-out">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-2xl">{{ data.penyewa }}</p>
                    <p class="text-sm">Jumlah Penyewa Bulan Ini</p>
                </div>
            </div>
            <div
                class="bg-default-dark dark:bg-gray-800 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-blue-600 dark:border-gray-600 text-white font-medium group">
                <div
                    class="flex justify-center items-center w-14 h-14 bg-white rounded-full transition-all duration-300 transform group-hover:rotate-12">
                    <svg width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="stroke-current text-default-dark dark:text-gray-800 transform transition-transform duration-500 ease-in-out">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-2xl">{{ data.mobilSewa }}</p>
                    <p class="text-sm">Mobil Dalam Penyewaan</p>
                </div>
            </div>
            <div
                class="bg-default-dark dark:bg-gray-800 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-blue-600 dark:border-gray-600 text-white font-medium group">
                <div
                    class="flex justify-center items-center w-14 h-14 bg-white rounded-full transition-all duration-300 transform group-hover:rotate-12">
                    <svg width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="stroke-current text-default-dark dark:text-gray-800 transform transition-transform duration-500 ease-in-out">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-lg">Rp. {{ Number(data.totalPendapatan).toLocaleString() }}</p>
                    <p>Jumlah Pendapatan</p>
                </div>
            </div>
            <div
                class="bg-default-dark dark:bg-gray-800 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-blue-600 dark:border-gray-600 text-white font-medium group">
                <div
                    class="flex justify-center items-center w-14 h-14 bg-white rounded-full transition-all duration-300 transform group-hover:rotate-12">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 text-default-dark">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M14.25 9v6m-4.5 0V9M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>

                </div>
                <div class="text-right">
                    <p class="text-2xl">{{ data.SewaTelat.length }}</p>
                    <p class="text-sm">Terlewat Masa Penyewaan</p>
                </div>
            </div>
        </div>
        <!-- ./Statistics Cards -->

        <div class="grid grid-cols-1 lg:grid-cols-2 p-4 gap-4">

            <!-- Social Traffic -->
            <div
                class="relative flex flex-col min-w-0 mb-4 lg:mb-0 break-words bg-gray-50 dark:bg-gray-800 w-full shadow-lg rounded">
                <div class="rounded-t mb-0 px-0 border-0">
                    <div class="flex flex-wrap items-center px-4 py-2">
                        <div class="relative w-full max-w-full flex-grow flex-1">
                            <h3 class="font-semibold text-base text-gray-900 dark:text-gray-50">Data Penyewaan Mobil
                            </h3>
                        </div>
                        <div class="relative w-full max-w-full flex-grow flex-1 text-right">
                            <Link :href="route('Mobil.index')"
                                class="bg-default-dark dark:bg-gray-100 text-white active:bg-blue-600 dark:text-gray-800 dark:active:text-gray-700 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                type="button">Lihat Semua</Link>
                        </div>
                    </div>
                    <div class="block w-full overflow-x-auto">
                        <table class="items-center w-full bg-transparent border-collapse">
                            <thead>
                                <tr>
                                    <th
                                        class="px-4 bg-gray-100 dark:bg-gray-600 text-gray-500 dark:text-gray-100 align-middle border border-solid border-gray-200 dark:border-gray-500 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                        Referral</th>
                                    <th
                                        class="px-4 bg-gray-100 dark:bg-gray-600 text-gray-500 dark:text-gray-100 align-middle border border-solid border-gray-200 dark:border-gray-500 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                        Visitors</th>
                                    <th
                                        class="px-4 bg-gray-100 dark:bg-gray-600 text-gray-500 dark:text-gray-100 align-middle border border-solid border-gray-200 dark:border-gray-500 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left min-w-140-px">
                                    </th>
                                </tr>
                            </thead>
                            <tbody v-for="(mobil, index) in MapMobil" :key="mobil" :index="index">
                                <tr v-for="item in mobil" :key="item" class="text-gray-700 dark:text-gray-100">
                                    <th v-if="item.status == 1"
                                        class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                                        {{ item.unit }}
                                    </th>
                                    <td v-if="item.status == 1">
                                        {{ item.status }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- ./Social Traffic -->

            <!-- Recent Activities -->
            <div
                class="relative flex flex-col min-w-0 break-words bg-gray-50 dark:bg-gray-800 w-full shadow-lg rounded">
                <div class="rounded-t mb-0 px-0 border-0">
                    <div class="flex flex-wrap items-center px-4 py-2">
                        <div class="relative w-full max-w-full flex-grow flex-1">
                            <h3 class="font-semibold text-base text-gray-900 dark:text-gray-50">Penyewaan Mobil Terbaru
                            </h3>
                        </div>
                        <div class="relative w-full max-w-full flex-grow flex-1 text-right">
                            <Link :href="route('Sewa.index')"
                                class="bg-default-dark dark:bg-gray-100 text-white active:bg-blue-600 dark:text-gray-800 dark:active:text-gray-700 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">Lihat Semua</Link>
                        </div>
                    </div>
                    <div class="block w-full">
                        <div
                            class="px-4 bg-gray-100 dark:bg-gray-600 text-gray-500 dark:text-gray-100 align-middle border border-solid border-gray-200 dark:border-gray-500 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                            Today
                        </div>
                        <ul class="my-1">
                            <li v-for="dateNow in forDate.today" :key="dateNow" class="flex px-4">
                                <div class="w-9 h-9 rounded-full flex-shrink-0 bg-indigo-500 my-2 mr-3">
                                    <svg class="w-9 h-9 fill-current text-indigo-50" viewBox="0 0 36 36">
                                        <path
                                            d="M18 10c-4.4 0-8 3.1-8 7s3.6 7 8 7h.6l5.4 2v-4.4c1.2-1.2 2-2.8 2-4.6 0-3.9-3.6-7-8-7zm4 10.8v2.3L18.9 22H18c-3.3 0-6-2.2-6-5s2.7-5 6-5 6 2.2 6 5c0 2.2-2 3.8-2 3.8z">
                                        </path>
                                    </svg>
                                </div>
                                <div
                                    class="flex-grow flex items-center border-b border-gray-100 dark:border-gray-400 text-sm text-gray-600 dark:text-gray-100 py-2">
                                    <div class="flex-grow flex justify-between items-center">
                                        <div class="self-center">
                                            <a class="font-medium text-gray-800 hover:text-gray-900 dark:text-gray-50 dark:hover:text-gray-100"
                                                href="#0" style="outline: none;">{{dateNow.kode}}</a> ,Penyewa <a
                                                class="font-medium text-gray-800 dark:text-gray-50 dark:hover:text-gray-100"
                                                href="#0" style="outline: none;">{{dateNow.pengguna.nama}}</a>
                                        </div>
                                        <div class="flex-shrink-0 ml-2">
                                            <Link class="flex items-center font-medium text-blue-500 hover:text-blue-600 dark:text-blue-400 dark:hover:text-blue-500"
                                                :href="route('Sewa.show', {id:dateNow.id})" style="outline: none;">
                                                View<span><svg width="20" height="20" viewBox="0 0 20 20"
                                                        fill="currentColor"
                                                        class="transform transition-transform duration-500 ease-in-out">
                                                        <path fill-rule="evenodd"
                                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                            clip-rule="evenodd"></path>
                                                    </svg></span>
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div
                            class="px-4 bg-gray-100 dark:bg-gray-600 text-gray-500 dark:text-gray-100 align-middle border border-solid border-gray-200 dark:border-gray-500 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                            Yesterday
                        </div>
                        <ul class="my-1">
                            <li v-for="sewadate in forDate.yesterday" :key="sewadate" class="flex px-4">
                                <div class="w-9 h-9 rounded-full flex-shrink-0 bg-green-500 my-2 mr-3">
                                    <svg class="w-9 h-9 fill-current text-light-blue-50" viewBox="0 0 36 36">
                                        <path
                                            d="M23 11v2.085c-2.841.401-4.41 2.462-5.8 4.315-1.449 1.932-2.7 3.6-5.2 3.6h-1v2h1c3.5 0 5.253-2.338 6.8-4.4 1.449-1.932 2.7-3.6 5.2-3.6h3l-4-4zM15.406 16.455c.066-.087.125-.162.194-.254.314-.419.656-.872 1.033-1.33C15.475 13.802 14.038 13 12 13h-1v2h1c1.471 0 2.505.586 3.406 1.455zM24 21c-1.471 0-2.505-.586-3.406-1.455-.066.087-.125.162-.194.254-.316.422-.656.873-1.028 1.328.959.878 2.108 1.573 3.628 1.788V25l4-4h-3z">
                                        </path>
                                    </svg>
                                </div>
                                <div
                                    class="flex-grow flex items-center border-gray-100 text-sm text-gray-600 dark:text-gray-50 py-2">
                                    <div class="flex-grow flex justify-between items-center">
                                        <div class="self-center">
                                            <a class="font-medium text-gray-800 hover:text-gray-900 dark:text-gray-50 dark:hover:text-gray-100"
                                                href="#0" style="outline: none;">{{sewadate.kode}}</a> ,Penyewa
                                            to <a
                                                class="font-medium text-gray-800 dark:text-gray-50 dark:hover:text-gray-100"
                                                href="#0" style="outline: none;">{{ sewadate.pengguna.nama }}</a>
                                        </div>
                                        <div class="flex-shrink-0 ml-2">
                                            <a class="flex items-center font-medium text-blue-500 hover:text-blue-600 dark:text-blue-400 dark:hover:text-blue-500"
                                                href="#0" style="outline: none;">
                                                View<span><svg width="20" height="20" viewBox="0 0 20 20"
                                                        fill="currentColor"
                                                        class="transform transition-transform duration-500 ease-in-out">
                                                        <path fill-rule="evenodd"
                                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                            clip-rule="evenodd"></path>
                                                    </svg></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- ./Recent Activities -->
        </div>

        <!-- External resources -->
        <div class="mt-8 mx-4">
            <div
                class="p-4 bg-blue-50 dark:bg-gray-800 dark:text-gray-50 border border-blue-500 dark:border-gray-500 rounded-lg shadow-md">
                <h4 class="text-lg font-semibold">Have taken ideas & reused components from the following
                    resources:</h4>
                <ul>
                    <li class="mt-3">
                        <a class="flex items-center text-blue-700 dark:text-gray-100"
                            href="https://tailwindcomponents.com/component/sidebar-navigation-1" target="_blank">
                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                class="transform transition-transform duration-500 ease-in-out">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="inline-flex pl-2">Sidebar Navigation</span>
                        </a>
                    </li>
                    <li class="mt-2">
                        <a class="flex items-center text-blue-700 dark:text-gray-100"
                            href="https://tailwindcomponents.com/component/contact-form-1" target="_blank">
                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                class="transform transition-transform duration-500 ease-in-out">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="inline-flex pl-2">Contact Form</span>
                        </a>
                    </li>
                    <li class="mt-2">
                        <a class="flex items-center text-blue-700 dark:text-gray-100"
                            href="https://tailwindcomponents.com/component/trello-panel-clone" target="_blank">
                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                class="transform transition-transform duration-500 ease-in-out">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="inline-flex pl-2">Section: Task Summaries</span>
                        </a>
                    </li>
                    <li class="mt-2">
                        <a class="flex items-center text-blue-700 dark:text-gray-100"
                            href="https://windmill-dashboard.vercel.app/" target="_blank">
                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                class="transform transition-transform duration-500 ease-in-out">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="inline-flex pl-2">Section: Client Table</span>
                        </a>
                    </li>
                    <li class="mt-2">
                        <a class="flex items-center text-blue-700 dark:text-gray-100"
                            href="https://demos.creative-tim.com/notus-js/pages/admin/dashboard.html" target="_blank">
                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                class="transform transition-transform duration-500 ease-in-out">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="inline-flex pl-2">Section: Social Traffic</span>
                        </a>
                    </li>
                    <li class="mt-2">
                        <a class="flex items-center text-blue-700 dark:text-gray-100" href="https://mosaic.cruip.com"
                            target="_blank">
                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                class="transform transition-transform duration-500 ease-in-out">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="inline-flex pl-2">Section: Recent Activities</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- ./External resources -->
    </AuthenticatedLayout>
</template>
