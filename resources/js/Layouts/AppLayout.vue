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
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 md:flex">
                            <jet-nav-link :href="route('home')" :active="route().current('home')">
                                <span class="text-base">Accueil</span>
                            </jet-nav-link>
                            <jet-nav-link :href="route('dashboard')" :active="route().current('dashboard')">
                                <span class="text-base">Produits / Services</span>
                            </jet-nav-link>
                            <jet-nav-link :href="route('dashboard')" :active="route().current('dashboard')">
                                <span class="text-base">Contact</span>
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
                                <jet-dropdown align="right" width="48">
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
                                            Profil
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
                    <jet-responsive-nav-link :href="route('home')" :active="route().current('home')">
                        Accueil
                    </jet-responsive-nav-link>
                    <jet-responsive-nav-link :href="route('dashboard')" :active="route().current('dashboard')">
                        Produits / Services
                    </jet-responsive-nav-link>
                    <jet-responsive-nav-link :href="route('dashboard')" :active="route().current('dashboard')">
                        Contact
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
                <div class="pt-4 pb-1 border-t border-gray-200">
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
                            Profil
                        </jet-responsive-nav-link>

                        <!-- Authentication -->
                        <form method="POST" @submit.prevent="logout">
                            <jet-responsive-nav-link as="button">
                                Déconnexion
                            </jet-responsive-nav-link>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        <header v-if="showingHeader">
            <div class="max-w-7xl mx-auto py-4 sm:px-6 lg:px-8">
                <div class="bg-white shadow rounded p-3">
                    <slot name="header"></slot>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-grow">
            <slot></slot>
        </main>

        <!-- Modal Portal -->
        <!--<portal-target name="modal" multiple>
        </portal-target>-->

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

export default {
    components: {
        JetApplicationMark,
        JetDropdown,
        JetDropdownLink,
        JetNavLink,
        JetResponsiveNavLink,
    },

    props: ['showingHeader'],

    data() {
        return {
            showingNavigationDropdown: false,
        }
    },

    methods: {
        logout() {
            axios.post(route('logout').url()).then(response => {
                window.location = '/';
            })
        },
    }
}
</script>
