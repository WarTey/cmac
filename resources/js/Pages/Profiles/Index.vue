<template>
    <app-layout :showingHeader="true" :sidebarItems="null">
        <template #header>
            <h2 class="font-semibold text-gray-800 leading-tight">
                Mes profils
            </h2>
        </template>
        <div class="pt-8 md:pt-24 lg:pt-32 pb-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-6 md:grid-cols-5 gap-4">
                    <div class="flex justify-center col-span-2 md:col-span-1 cursor-pointer rounded-full border-2 transition duration-500" v-bind:class="classProfile(0)" v-on:click="selectProfile(0)">
                        <div class="flex flex-col items-center">
                            <div v-if="user.profiles.length > 0" :style="'background-image: url(/storage/profiles/1.png)'" class="bg-contain bg-center h-24 w-24 lg:h-32 lg:w-32 rounded-full shadow-lg hover:shadow-xl cursor-pointer transition duration-500"></div>
                            <div v-else class="bg-contain bg-center bg-add-profile h-24 w-24 lg:h-32 lg:w-32 rounded-full shadow-lg hover:shadow-xl cursor-pointer transition duration-500"></div>
                            <p v-if="user.profiles.length > 0" class="mt-2 text-center">{{ user.profiles[0].name }}</p>
                            <p v-else class="mt-2 text-center">Ajouter un profil</p>
                        </div>
                    </div>
                    <div class="flex justify-center col-span-2 md:col-span-1 cursor-pointer rounded-full border-2 transition duration-500" v-bind:class="classProfile(1)" v-on:click="selectProfile(1)">
                        <div class="flex flex-col items-center">
                            <div v-if="user.profiles.length > 1" :style="'background-image: url(/storage/profiles/1.png)'" class="bg-contain bg-center h-24 w-24 lg:h-32 lg:w-32 rounded-full shadow-lg hover:shadow-xl cursor-pointer transition duration-500"></div>
                            <div v-else class="bg-contain bg-center bg-add-profile h-24 w-24 lg:h-32 lg:w-32 rounded-full shadow-lg hover:shadow-xl transition duration-500"></div>
                            <p v-if="user.profiles.length > 1" class="mt-2 text-center">{{ user.profiles[1].name }}</p>
                            <p v-else class="mt-2 text-center">Ajouter un profil</p>
                        </div>
                    </div>
                    <div class="flex justify-center col-span-2 md:col-span-1 cursor-pointer rounded-full border-2 transition duration-500" v-bind:class="classProfile(2)" v-on:click="selectProfile(2)">
                        <div class="flex flex-col items-center">
                            <div v-if="user.profiles.length > 2" :style="'background-image: url(/storage/profiles/1.png)'" class="bg-contain bg-center h-24 w-24 lg:h-32 lg:w-32 rounded-full shadow-lg hover:shadow-xl cursor-pointer transition duration-500"></div>
                            <div v-else class="bg-contain bg-center bg-add-profile h-24 w-24 lg:h-32 lg:w-32 rounded-full shadow-lg hover:shadow-xl transition duration-500"></div>
                            <p v-if="user.profiles.length > 2" class="mt-2 text-center">{{ user.profiles[2].name }}</p>
                            <p v-else class="mt-2 text-center">Ajouter un profil</p>
                        </div>
                    </div>
                    <div class="flex justify-center mt-8 md:mt-0 col-start-2 md:col-start-4 col-span-2 md:col-span-1 cursor-pointer rounded-full border-2 transition duration-500" v-bind:class="classProfile(3)" v-on:click="selectProfile(3)">
                        <div class="flex flex-col items-center">
                            <div v-if="user.profiles.length > 3" :style="'background-image: url(/storage/profiles/1.png)'" class="bg-contain bg-center h-24 w-24 lg:h-32 lg:w-32 rounded-full shadow-lg hover:shadow-xl cursor-pointer transition duration-500"></div>
                            <div v-else class="bg-contain bg-center bg-add-profile h-24 w-24 lg:h-32 lg:w-32 rounded-full shadow-lg hover:shadow-xl transition duration-500"></div>
                            <p v-if="user.profiles.length > 3" class="mt-2 text-center">{{ user.profiles[3].name }}</p>
                            <p v-else class="mt-2 text-center">Ajouter un profil</p>
                        </div>
                    </div>
                    <div class="flex justify-center mt-8 md:mt-0 col-span-2 md:col-span-1 cursor-pointer rounded-full border-2 transition duration-500" v-bind:class="classProfile(4)" v-on:click="selectProfile(4)">
                        <div class="flex flex-col items-center">
                            <div v-if="user.profiles.length > 4" :style="'background-image: url(/storage/profiles/1.png)'" class="bg-contain bg-center h-24 w-24 lg:h-32 lg:w-32 rounded-full shadow-lg hover:shadow-xl cursor-pointer transition duration-500"></div>
                            <div v-else class="bg-contain bg-center bg-add-profile h-24 w-24 lg:h-32 lg:w-32 rounded-full shadow-lg hover:shadow-xl transition duration-500"></div>
                            <p v-if="user.profiles.length > 4" class="mt-2 text-center">{{ user.profiles[4].name }}</p>
                            <p v-else class="mt-2 text-center">Ajouter un profil</p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row justify-center items-center pt-24">
                    <button v-on:click="useProfile" class="bg-blue-500 w-40 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Utiliser ce profil
                    </button>
                    <button v-on:click="showEditForm" class="mt-4 md:mt-0 md:ml-4 bg-blue-500 w-40 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Modifier ce profil
                    </button>
                </div>
                <div class="flex justify-center items-center pt-8">
                    <button v-on:click="deleteProfile" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Supprimer ce profil
                    </button>
                </div>
            </div>
        </div>
        <div v-if="showEditProfile || showCreateProfile" class="fixed overflow-hidden top-0 left-0 flex items-center justify-center w-full h-full bg-black bg-opacity-50">
            <form class="bg-white shadow-md rounded px-8 md:max-w-xl w-full max-h-4/5 overflow-auto" @submit.prevent="sendForm">
                <div class="mb-4 mt-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                        Nom du profil
                    </label>
                    <input v-if="$page.errors.name" class="shadow appearance-none border border-red-700 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" v-model="form.name" placeholder="Nom du profil">
                    <input v-else class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" v-model="form.name" placeholder="Nom du profil">
                    <p class="text-red-700 mt-2" v-if="$page.errors.name">{{ $page.errors.name[0] }}</p>
                </div>
                <div class="text-green-700" v-if="$page.flash.success">
                    {{ $page.flash.success }}
                </div>
                <div class="mt-4 mb-6">
                    <span class="flex w-full rounded">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                            Enregistrer
                        </button>
                        <button v-on:click="closeForm" class="ml-auto bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Fermer
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";

export default {
    components: {
        AppLayout
    },

    props: ['user'],

    data() {
        return {
            selected: null,
            showEditProfile: false,
            showCreateProfile: false,
            form: {
                name: null
            }
        }
    },

    mounted() {
        this.user.profiles.forEach((element, index) => {
            if (element.active === 1) {
                this.selected =  index;
            }
        });
    },

    methods: {
        selectProfile(index) {
            if (this.user.profiles.length > index) {
                this.selected = index;
            } else {
                this.showCreateProfile = !this.showCreateProfile;
            }
        },

        classProfile(index) {
            if (this.user.profiles.length > index && index === this.selected) {
                return {
                    'border-gray-400': true
                }
            } else {
                return {
                    'border-transparent': true,
                    'hover:border-gray-400': this.user.profiles.length > index,
                }
            }
        },

        showEditForm() {
            this.form.name = this.user.profiles[this.selected].name;
            this.showEditProfile = !this.showEditProfile;
        },

        deleteProfile() {
            if (this.user.profiles.length > 0) {
                toastr.warning("Imposible de supprimer votre dernier profil.");
            } else if (confirm("Voulez-vous supprimer le profil " + this.user.profiles[this.selected].name + " ?")) {
                const formData = new FormData();
                formData.append('id', this.user.profiles[this.selected].id);

                this.selectProfile(0);

                this.$inertia.post('/profils/delete', formData);
            }
        },

        sendForm() {
            const formData = new FormData();
            if (this.showEditProfile) {
                formData.append('id', this.user.profiles[this.selected].id);
            }
            if (this.form.name) {
                formData.append('name', this.form.name);
            }

            if (this.showEditProfile) {
                this.$inertia.post('/profils/edit', formData);
            } else if (this.user.profiles.length < 5) {
                this.$inertia.post('/profils/create', formData);
            }
        },

        closeForm() {
            this.showCreateProfile = false;
            this.showEditProfile = false;
            this.form.name = null;
            this.clearFormMessages();
        },

        clearFormMessages() {
            this.$page.errors = {};
            this.$page.flash = {};
        },

        useProfile() {
            if (this.user.profiles[this.selected].active === 1) {
                if (this.user.admin === 1) {
                    window.location = '/dashboard';
                } else {
                    window.location = '/formations';
                }
            } else {
                this.$inertia.post('/profils/select', {
                    id: this.user.profiles[this.selected].id
                });
            }
        }
    }
}
</script>
