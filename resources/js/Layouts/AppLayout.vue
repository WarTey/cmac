<template>
    <div class="min-h-screen bg-general-texture flex flex-col">
        <nav class="bg-transparent border-transparent">
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center">
                            <inertia-link :href="route('home')">
                                <img class="h-15" :src="'/img/logo.webp'" alt="Logo CMAC">
                            </inertia-link>
                            <inertia-link :href="route('home')">
                                <span class="text-lg font-bold ml-2 text-gray-500 hover:text-gray-700">CMAC</span>
                            </inertia-link>
                        </div>
                    </div>

                    <div class="flex">
                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 lg:flex">
                            <jet-nav-link :href="route('profile.show')">
                                Produits et services
                            </jet-nav-link>
                            <jet-nav-link :href="route('profile.show')">
                                Cours et exercices
                            </jet-nav-link>
                            <jet-nav-link :href="route('profile.show')">
                                Livre d'or et forum
                            </jet-nav-link>
                            <jet-nav-link :href="route('profile.show')">
                                Articles
                            </jet-nav-link>
                            <jet-nav-link :href="route('profile.show')">
                                Annuaire des anciens
                            </jet-nav-link>
                        </div>
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 md:flex lg:hidden">
                            <jet-nav-link>
                                <jet-dropdown align="right" width="48">
                                    <template #trigger>
                                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                            <div class="text-base">Menu</div>

                                            <div class="ml-1">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </button>
                                    </template>

                                    <template #content>
                                        <jet-dropdown-link :href="route('profile.show')">
                                            Produits et services
                                        </jet-dropdown-link>
                                        <jet-dropdown-link :href="route('dashboard.index')">
                                            Cours et exercices
                                        </jet-dropdown-link>
                                        <jet-dropdown-link :href="route('dashboard.index')">
                                            Livre d'or et forum
                                        </jet-dropdown-link>
                                        <jet-dropdown-link :href="route('dashboard.index')">
                                            Articles
                                        </jet-dropdown-link>
                                        <jet-dropdown-link :href="route('dashboard.index')">
                                            Annuaire des anciens
                                        </jet-dropdown-link>
                                    </template>
                                </jet-dropdown>
                            </jet-nav-link>
                        </div>
                    </div>

                    <div class="flex">
                        <!-- Settings Dropdown -->
                        <div class="hidden md:flex sm:items-center sm:ml-6">
                            <inertia-link :href="route('home')">
                                <i class="fab fa-facebook-f fa-lg mr-4 text-gray-500 hover:text-gray-700"></i>
                            </inertia-link>
                            <inertia-link :href="route('home')">
                                <i class="fab fa-instagram fa-lg mr-4 text-gray-500 hover:text-gray-700"></i>
                            </inertia-link>
                            <inertia-link :href="route('home')">
                                <i class="fab fa-youtube fa-lg mr-4 text-gray-500 hover:text-gray-700"></i>
                            </inertia-link>
                            <inertia-link :href="route('home')">
                                <i class="fab fa-linkedin-in fa-lg mr-1 text-gray-500 hover:text-gray-700"></i>
                            </inertia-link>
                            <div class="ml-3 relative">
                                <jet-dropdown align="right" width="48" v-if="$page.user">
                                    <template #trigger>
                                        <button v-if="$page.user.profile_photo_url" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                                            <img class="h-10 w-10 rounded-full object-cover" :src="$page.user.profile_photo_url" :alt="$page.user.name" />
                                        </button>

                                        <button v-else class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                            <div>{{ $page.user.name }}</div>

                                            <div class="ml-1">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </button>
                                    </template>

                                    <template #content>
                                        <!-- Account Management -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            Gestion du compte
                                        </div>

                                        <jet-dropdown-link :href="route('profile.show')">
                                            Mon compte
                                        </jet-dropdown-link>

                                        <jet-dropdown-link v-if="$page.user && $page.user.admin" :href="route('dashboard.index')">
                                            Dashboard
                                        </jet-dropdown-link>

                                        <div class="border-t border-gray-100"></div>

                                        <!-- Authentication -->
                                        <form @submit.prevent="logout">
                                            <jet-dropdown-link as="button">
                                                Déconnexion
                                            </jet-dropdown-link>
                                        </form>
                                    </template>
                                </jet-dropdown>

                                <button v-else class="bg-gray-100 hover:bg-gray-200 text-gray-500 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline border border-gray-400" v-on:click="showConnectionForm">
                                    Connexion
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Hamburger -->
                    <div class="-mr-2 flex items-center md:hidden">
                        <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="md:hidden">
                <div class="pt-2 pb-3 space-y-1">
                    <jet-responsive-nav-link :href="route('profile.show')">
                        Produits et services
                    </jet-responsive-nav-link>
                    <jet-responsive-nav-link :href="route('dashboard.index')">
                        Cours et exercices
                    </jet-responsive-nav-link>
                    <jet-responsive-nav-link :href="route('dashboard.index')">
                        Livre d'or et forum
                    </jet-responsive-nav-link>
                    <jet-responsive-nav-link :href="route('dashboard.index')">
                        Articles
                    </jet-responsive-nav-link>
                    <jet-responsive-nav-link :href="route('dashboard.index')">
                        Annuaire des anciens
                    </jet-responsive-nav-link>
                    <inertia-link :href="route('home')">
                        <i class="fab fa-facebook-f fa-lg py-4 pl-3 mr-3 border-l-4 border-transparent text-gray-500 hover:text-gray-700"></i>
                    </inertia-link>
                    <inertia-link :href="route('home')">
                        <i class="fab fa-instagram fa-lg py-4 mr-3 text-gray-500 hover:text-gray-700"></i>
                    </inertia-link>
                    <inertia-link :href="route('home')">
                        <i class="fab fa-youtube fa-lg py-4 mr-3 text-gray-500 hover:text-gray-700"></i>
                    </inertia-link>
                    <inertia-link :href="route('home')">
                        <i class="fab fa-linkedin-in py-4 fa-lg text-gray-500 hover:text-gray-700"></i>
                    </inertia-link>
                </div>

                <!-- Responsive Settings Options -->
                <div v-if="$page.user" class="pt-4 pb-1 border-t border-gray-200">
                    <div class="flex items-center px-4">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full" :src="$page.user.profile_photo_url" :alt="$page.user.name" />
                        </div>

                        <div class="ml-3">
                            <div class="font-medium text-base text-gray-800">{{ $page.user.name }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ $page.user.email }}</div>
                        </div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <jet-responsive-nav-link :href="route('profile.show')" :active="route().current('profile.show')">
                            Mon compte
                        </jet-responsive-nav-link>

                        <jet-responsive-nav-link v-if="$page.user && $page.user.admin" :href="route('dashboard.index')" :active="route().current('profile.show')">
                            Dashboard
                        </jet-responsive-nav-link>

                        <!-- Authentication -->
                        <form method="POST" @submit.prevent="logout">
                            <jet-responsive-nav-link as="button">
                                Déconnexion
                            </jet-responsive-nav-link>
                        </form>
                    </div>
                </div>

                <div v-else class="pb-1 ml-3">
                    <button class="bg-gray-100 hover:bg-gray-200 text-gray-500 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline border border-gray-400" v-on:click="showConnectionForm">
                        Connexion
                    </button>
                </div>
            </div>
        </nav>

        <!-- Side Heading -->
        <div v-if="sidebarItems && showingNavigationSide" class="fixed overflow-hidden top-0 left-0 flex items-center justify-center w-full h-full bg-black bg-opacity-50"></div>
        <div class="flex flex-wrap h-full fixed bg-white cursor-pointer text-2xl items-center" v-if="!showingNavigationSide && sidebarItems">
            <i class="fas fa-angle-double-right fa-lg text-gray-500 hover:text-gray-700 fixed pl-4 bg-white pr-2 py-2 rounded-r shadow-md hover:shadow-lg" v-on:click="showingNavigationSide = !showingNavigationSide"></i>
        </div>
        <aside v-if="sidebarItems" class="flex flex-col z-30 rounded-r-lg transform top-0 left-0 w-64 bg-white fixed h-full overflow-auto ease-in-out transition-all duration-300" :class="showingNavigationSide ? 'translate-x-0' : '-translate-x-full'">
            <div class="flex flex-col items-center mb-3 w-10/12 mx-auto">
                <input v-on:keyup="updateSidebar" class="mt-4 border-b-2 border-gray-300 h-10 focus:outline-none" placeholder="Recherche">
            </div>
            <div class="flex-grow">
                <div v-for="(level, index) in copySidebarItems" :key="index">
                    <span v-if="level['visible']" class="flex items-center py-1 px-2 mx-auto text-base">
                        <span class="mr-4">-</span>
                        <a :href="'/formation/' + level.uuid" class="mr-2 text-gray-500 hover:text-gray-700 cursor-pointer hover:underline">
                            {{ level.title }}
                        </a>
                        <span v-if="level['chapters'] && level['chapters'].length > 0" class="ml-auto">
                            <i v-if="!level['unrolled']" class="fas fa-chevron-right text-gray-500 hover:text-gray-700 cursor-pointer" v-on:click="dropMenu(level)"></i>
                            <i v-else class="fas fa-chevron-down text-gray-500 hover:text-gray-700 cursor-pointer" v-on:click="dropMenu(level)"></i>
                        </span>
                    </span>
                    <div v-if="level['visible'] && level['unrolled']" v-for="(chapter, index) in level['chapters']" :key="index">
                        <span v-if="chapter['visible']" class="flex items-center py-1 pr-2 pl-8 mx-auto text-base">
                            <span class="mr-4">-</span>
                            <a :href="'/chapitre/' + chapter.uuid" class="text-gray-500 hover:text-gray-700 cursor-pointer hover:underline">
                                {{ chapter.title }}
                            </a>
                            <span v-if="chapter['courses'] && chapter['courses'].length > 0" class="ml-auto">
                                <i v-if="!chapter['unrolled']" class="fas fa-chevron-right text-gray-500 hover:text-gray-700 cursor-pointer" v-on:click="dropMenu(chapter)"></i>
                                <i v-else class="fas fa-chevron-down text-gray-500 hover:text-gray-700 cursor-pointer" v-on:click="dropMenu(chapter)"></i>
                            </span>
                        </span>
                        <div v-if="chapter['unrolled'] && chapter['visible']" v-for="(course, index) in chapter['courses']" :key="index">
                            <span v-if="course['visible']" class="flex items-center py-1 pr-2 pl-14 mx-auto text-base">
                                <span class="mr-4">-</span>
                                <a :href="'/cours/' + course.uuid" class="text-gray-500 hover:text-gray-700 cursor-pointer hover:underline">
                                    {{ course.title }}
                                </a>
                                <span v-if="course['contents'] && course['contents'].length > 0" class="ml-auto">
                                    <i v-if="!course['unrolled']" class="fas fa-chevron-right text-gray-500 hover:text-gray-700 cursor-pointer" v-on:click="dropMenu(course)"></i>
                                    <i v-else class="fas fa-chevron-down text-gray-500 hover:text-gray-700 cursor-pointer" v-on:click="dropMenu(course)"></i>
                                </span>
                            </span>
                            <!--<div v-if="course['visible']" v-for="(content, index) in course['contents']" :key="index">
                                <span class="flex items-center py-1 pr-2 pl-20 mx-auto text-base">
                                    <span class="mr-4">-</span>
                                    <span class="text-gray-500 hover:text-gray-700 cursor-pointer hover:underline">
                                        {{ content.title }}
                                    </span>
                                </span>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col items-center">
                <button class="bg-red-500 hover:bg-red-700 mt-2 mb-4 w-10/12 rounded focus:outline-none focus:shadow-outline text-white font-bold py-2 px-4" v-on:click="showingNavigationSide = !showingNavigationSide">
                    Fermer
                </button>
            </div>
        </aside>

        <!-- Page Heading -->
        <header v-if="showingHeader">
            <div class="max-w-7xl mx-auto py-4 sm:px-6 lg:px-8">
                <div class="bg-white shadow rounded p-3">
                    <slot name="header"></slot>
                </div>
            </div>
        </header>

        <!-- Modal -->
        <LoginForm :showLogin="loginForm" @updateLoginForm="updateLoginForm"></LoginForm>

        <!-- Page Content -->
        <main class="flex-grow">
            <slot></slot>
        </main>

        <!-- Footer Content -->
        <footer class="bg-gray-600 w-full static bottom-0 mt-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12">
                <div class="grid grid-cols-2 gap-3 pb-4 md:grid-cols-4">
                    <div class="col-span-2">
                        <div class="uppercase text-white font-bold text-base mb-2">
                            Réseaux sociaux
                        </div>
                        <div class="flex">
                            <inertia-link :href="route('home')">
                                <i class="fab fa-facebook-f fa-lg py-4 pr-4 text-white hover:text-gray-300"></i>
                            </inertia-link>
                            <inertia-link :href="route('home')">
                                <i class="fab fa-instagram fa-lg py-4 pl-4 pr-4 text-white hover:text-gray-300"></i>
                            </inertia-link>
                            <inertia-link :href="route('home')">
                                <i class="fab fa-youtube fa-lg py-4 pl-4 pr-4 text-white hover:text-gray-300"></i>
                            </inertia-link>
                            <inertia-link :href="route('home')">
                                <i class="fab fa-linkedin-in py-4 pl-4 fa-lg text-white hover:text-gray-300"></i>
                            </inertia-link>
                        </div>
                    </div>
                    <div class="col-span-2 md:hidden">
                        <div class="mb-4 mt-4 border-t border-gray-400 md:hidden"></div>
                    </div>
                    <div>
                        <div class="uppercase text-white font-bold text-base mb-2">
                            Liens utiles
                        </div>
                        <p>
                            <inertia-link :href="route('home')">
                                <span class="text-sm font-semibold text-white hover:text-gray-300 hover:underline">À propos de nous</span>
                            </inertia-link>
                        </p>
                        <p>
                            <inertia-link :href="route('home')">
                                <span class="text-sm font-semibold text-white hover:text-gray-300 hover:underline">Plan du site</span>
                            </inertia-link>
                        </p>
                        <p>
                            <inertia-link :href="route('home')">
                                <span class="text-sm font-semibold text-white hover:text-gray-300 hover:underline">Annuaire des anciens</span>
                            </inertia-link>
                        </p>
                    </div>
                    <div>
                        <div class="uppercase text-white font-bold text-base mb-2">
                            Liens utiles
                        </div>
                        <p>
                            <inertia-link :href="route('home')">
                                <span class="text-sm font-semibold text-white hover:text-gray-300 hover:underline">Ressources</span>
                            </inertia-link>
                        </p>
                        <p>
                            <inertia-link :href="route('home')">
                                <span class="text-sm font-semibold text-white hover:text-gray-300 hover:underline">Livre d'or</span>
                            </inertia-link>
                        </p>
                        <p>
                            <inertia-link :href="route('home')">
                                <span class="text-sm font-semibold text-white hover:text-gray-300 hover:underline">S'inscrire à la Newsletter</span>
                            </inertia-link>
                        </p>
                    </div>
                </div>
                <div class="py-4 text-sm font-semibold text-white text-center">
                    <span>© 2020 Copyright :</span>
                    <inertia-link :href="route('home')">
                        <span class="hover:text-gray-300 hover:underline">CMAC</span>
                    </inertia-link>
                </div>
            </div>
        </footer>
    </div>
</template>

<script>
import JetApplicationMark from '@/Jetstream/ApplicationMark'
import JetDropdown from '@/Jetstream/Dropdown'
import JetDropdownLink from '@/Jetstream/DropdownLink'
import JetNavLink from '@/Jetstream/NavLink'
import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink'
import JetButton from '@/Jetstream/Button'
import LoginForm from "@/Layouts/LoginForm";

export default {
    components: {
        JetApplicationMark,
        JetDropdown,
        JetDropdownLink,
        JetNavLink,
        JetResponsiveNavLink,
        JetButton,
        LoginForm
    },

    props: ['showingHeader', 'sidebarItems'],

    watch: {
        sidebarItems: function (value) {
            this.sidebarItems = value;
            this.copyItems();
        }
    },

    data() {
        return {
            showingNavigationDropdown: false,
            showingNavigationSide: false,
            copySidebarItems: null,
            loginForm: false
        }
    },

    mounted() {
        this.copyItems();
    },

    methods: {
        logout() {
            axios.post(route('logout').url()).then(() => {
                window.location = '/';
            });
        },

        copyItems() {
            this.copySidebarItems = this.sidebarItems;
            if (this.sidebarItems) {
                this.copySidebarItems.forEach(element => {
                    element['unrolled'] = false;
                    element['visible'] = true;
                    element['chapters'].forEach(element => {
                        element['unrolled'] = false;
                        element['visible'] = true;
                        element['courses'].forEach(element => {
                            element['unrolled'] = false;
                            element['visible'] = true;
                        });
                    });
                });
            }
        },

        dropMenu(item) {
            item['unrolled'] = !item['unrolled'];
            this.refreshSidebar();
        },

        refreshSidebar() {
            this.showingNavigationSide = !this.showingNavigationSide;
            this.showingNavigationSide = !this.showingNavigationSide;
        },

        showConnectionForm() {
            this.loginForm = true;
        },

        updateLoginForm(value) {
            this.loginForm = value;
        },

        updateSidebar(search) {
            if (this.sidebarItems) {
                this.copySidebarItems.forEach(element => {
                    element['chapters'].forEach(element => {
                        element['courses'].forEach(element => {
                            element['visible'] = element.title.includes(search.target.value);
                        });
                        element['visible'] = element['courses'].filter(course => course['visible']).length > 0 || element.title.includes(search.target.value);
                    });
                    element['visible'] = element['chapters'].filter(course => course['visible']).length > 0 || element.title.includes(search.target.value);
                });
                this.refreshSidebar();
            }
        }
    }
}
</script>
