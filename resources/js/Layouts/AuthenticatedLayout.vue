
<script setup>
import { ref, watch, onUnmounted, onMounted, onBeforeMount } from 'vue';

const navShow = localStorage.getItem('Shownav');
const ShowNav = ref();


function withChange() {
    if (window.innerWidth > 768) {
        ShowNav.value = false;
    } else {
        ShowNav.value = true;
    }

}
function openNav() {
    if (ShowNav.value) {
        ShowNav.value = false;
    } else {
        ShowNav.value = true;
    }
}
onMounted(() => {
    withChange()
})
</script>

<template>
    <!-- component -->
    <div>
        <div
            class="min-h-screen flex flex-col flex-auto flex-shrink-0 antialiased bg-white dark:bg-gray-700 text-black dark:text-white">

            <!-- Header -->
            <div class="fixed w-full flex items-center justify-between h-14 text-white z-10">
                <div
                    class="flex items-center justify-start md:justify-center pl-3 w-14 md:w-64 h-14 bg-gray-700 dark:bg-gray-800 border-none">
                    <img class=" hidden md:block w-7 h-7 md:w-10 md:h-10 mr-2 rounded-md overflow-hidden"
                        src="https://therminic2018.eu/wp-content/uploads/2018/07/dummy-avatar.jpg" />
                    <span class=" md:block cursor-pointer " @click="openNav()">
                        <svg v-if="ShowNav" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                        <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12H12m-8.25 5.25h16.5" />
                        </svg>

                    </span>
                </div>
                <div class="flex justify-between items-center h-14 bg-gray-700 dark:bg-gray-800 header-right">
                    <!-- <div
                        class="bg-white rounded flex items-center w-full max-w-xl mr-4 p-2 shadow-sm border border-gray-200">
                        <button class="outline-none focus:outline-none">
                            <svg class="w-5 text-gray-600 h-5 cursor-pointer" fill="none" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                        <input type="search" name="" id="" placeholder="Search" :value="$page.props.auth.user.name"
                            class="w-full pl-3 text-sm text-black outline-none focus:outline-none bg-transparent" />
                    </div> -->
                    <ul class="flex items-center">

                        <li>
                            <div class="block w-px h-6 mx-3 bg-gray-400 dark:bg-gray-700"></div>
                        </li>
                        <li>
                            <Link :href="route('logout')" :method="`POST`" type="button" as="button"
                                class="flex items-center mr-4 hover:text-blue-100">
                            <span class="inline-flex mr-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                            </span>
                            Logout
                            </Link>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- ./Header -->

            <!-- Sidebar -->
            <SidebarVue :class="ShowNav ? 'w-0' : 'w-64'"></SidebarVue>
            <!-- ./Sidebar -->

            <div class="h-full  mt-14 mb-10  md:px-2 md:py-5" :class="ShowNav ? 'ml-0' : 'ml-14 md:ml-64'">
                <slot />
            </div>
        </div>
    </div>

</template>

<script>
import NavLink from '@/Components/NavLink.vue';
import SidebarVue from '../Components/Sidebar.vue';
import { Link } from '@inertiajs/inertia-vue3'


export default {
    name: "AuthenticatedLayoutVue",
    components: { NavLink, SidebarVue, Link }
}
</script>
<style>
/* Compiled dark classes from Tailwind */
.dark .dark\:divide-gray-700> :not([hidden])~ :not([hidden]) {
    border-color: rgba(55, 65, 81);
}

.dark .dark\:bg-gray-50 {
    background-color: rgba(249, 250, 251);
}

.dark .dark\:bg-gray-100 {
    background-color: rgba(243, 244, 246);
}

.dark .dark\:bg-gray-600 {
    background-color: rgba(75, 85, 99);
}

.dark .dark\:bg-gray-700 {
    background-color: rgba(55, 65, 81);
}

.dark .dark\:bg-gray-800 {
    background-color: rgba(31, 41, 55);
}

.dark .dark\:bg-gray-900 {
    background-color: rgba(17, 24, 39);
}

.dark .dark\:bg-red-700 {
    background-color: rgba(185, 28, 28);
}

.dark .dark\:bg-green-700 {
    background-color: rgba(4, 120, 87);
}

.dark .dark\:hover\:bg-gray-200:hover {
    background-color: rgba(229, 231, 235);
}

.dark .dark\:hover\:bg-gray-600:hover {
    background-color: rgba(75, 85, 99);
}

.dark .dark\:hover\:bg-gray-700:hover {
    background-color: rgba(55, 65, 81);
}

.dark .dark\:hover\:bg-gray-900:hover {
    background-color: rgba(17, 24, 39);
}

.dark .dark\:border-gray-100 {
    border-color: rgba(243, 244, 246);
}

.dark .dark\:border-gray-400 {
    border-color: rgba(156, 163, 175);
}

.dark .dark\:border-gray-500 {
    border-color: rgba(107, 114, 128);
}

.dark .dark\:border-gray-600 {
    border-color: rgba(75, 85, 99);
}

.dark .dark\:border-gray-700 {
    border-color: rgba(55, 65, 81);
}

.dark .dark\:border-gray-900 {
    border-color: rgba(17, 24, 39);
}

.dark .dark\:hover\:border-gray-800:hover {
    border-color: rgba(31, 41, 55);
}

.dark .dark\:text-white {
    color: rgba(255, 255, 255);
}

.dark .dark\:text-gray-50 {
    color: rgba(249, 250, 251);
}

.dark .dark\:text-gray-100 {
    color: rgba(243, 244, 246);
}

.dark .dark\:text-gray-200 {
    color: rgba(229, 231, 235);
}

.dark .dark\:text-gray-400 {
    color: rgba(156, 163, 175);
}

.dark .dark\:text-gray-500 {
    color: rgba(107, 114, 128);
}

.dark .dark\:text-gray-700 {
    color: rgba(55, 65, 81);
}

.dark .dark\:text-gray-800 {
    color: rgba(31, 41, 55);
}

.dark .dark\:text-red-100 {
    color: rgba(254, 226, 226);
}

.dark .dark\:text-green-100 {
    color: rgba(209, 250, 229);
}

.dark .dark\:text-blue-400 {
    color: rgba(96, 165, 250);
}

.dark .group:hover .dark\:group-hover\:text-gray-500 {
    color: rgba(107, 114, 128);
}

.dark .group:focus .dark\:group-focus\:text-gray-700 {
    color: rgba(55, 65, 81);
}

.dark .dark\:hover\:text-gray-100:hover {
    color: rgba(243, 244, 246);
}

.dark .dark\:hover\:text-blue-500:hover {
    color: rgba(59, 130, 246);
}

/* Custom style */
.header-right {
    width: calc(100% - 3.5rem);
}

.sidebar:hover {
    width: 16rem;
}

@media only screen and (min-width: 768px) {
    .header-right {
        width: calc(100% - 16rem);
    }
}
</style>
