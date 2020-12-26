<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-gray-800 leading-tight">
                Les formations
            </h2>
        </template>
        <!-- TODO : Add Admin verification -->
        <div class="pt-4 max-w-7xl mx-auto sm:px-6 lg:px-8 right-0">
            <div class="flex flex-row-reverse">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" v-on:click="addLevel = !addLevel">
                    Ajouter une formation
                </button>
            </div>
        </div>
        <transition name="slide-fade">
            <div class="py-4" v-if="addLevel">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="w-full">
                        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" @submit.prevent="submit">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                                    Niveau de formation
                                </label>
                                <input v-if="$page.errors.title" class="shadow appearance-none border border-red-700 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="title" type="text" v-model="form.title" placeholder="Niveau de formation">
                                <input v-else class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="title" type="text" v-model="form.title" placeholder="Niveau de formation">
                                <p class="text-red-700 mt-2" v-if="$page.errors.title">{{ $page.errors.title[0] }}</p>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                                    Description (optionnel)
                                </label>
                                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" v-model="form.description" placeholder="Description (optionnel)"></textarea>
                                <p class="text-red-700 mt-2" v-if="$page.errors.description">{{ $page.errors.description[0] }}</p>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">
                                    Image (optionnel)
                                </label>
                                <header class="border-dashed border-2 border-gray-400 py-12 flex flex-col justify-center items-center mb-4">
                                    <input id="hidden-input" type="file" class="hidden" v-on:change="updateFile">
                                    <button id="button" class="mt-2 rounded-sm text-sm px-3 py-1 bg-gray-200 hover:bg-gray-300 focus:shadow-outline focus:outline-none" @click.prevent="selectFile">
                                        Télécharger une image
                                    </button>
                                </header>
                                <ul id="gallery" class="flex flex-1 flex-wrap -m-1">
                                    <li id="empty" class="h-full w-full text-center flex flex-col items-center justify-center items-center">
                                        <img class="mx-auto w-32" :src="'/img/no-img.png'" alt="Aucune image sélectionnée">
                                        <span class="text-sm text-gray-500">Aucune image sélectionnée</span>
                                    </li>
                                </ul>
                                <div class="pt-4" v-if="this.form.image">
                                    <div class="font-semibold text-gray-700 text-sm">
                                        {{ this.form.image.name }} - <a href="#" v-on:click.prevent="resetFile" class="text-red-700 hover:underline">Supprimer</a>
                                    </div>
                                </div>
                                <p class="text-red-700 mt-2" v-if="$page.errors.image">{{ $page.errors.image[0] }}</p>
                            </div>
                            <div class="text-green-700 mb-4" v-if="$page.flash.success">
                                {{ $page.flash.success }}
                            </div>
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                Ajouter la formation
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </transition>
        <div class="py-4" v-for="level in $page.levels" v-bind:key="level.uuid">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-lg hover:shadow-xl sm:rounded-lg transition duration-500 ease-in-out">
                    <div v-if="level.image" class="h-20 bg-auto bg-center" :style="'background-image: url(/storage/img/levels/' + level.image + ')'"></div>
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <!-- TODO : Hide for user and link for admin -->
                            <a v-if="level.chapters_count < 1" href="#" class="text-2xl hover:underline">
                                Formation - {{ level.title }}
                            </a>
                            <a v-else :href="'/formation/' + level.uuid" class="text-2xl hover:underline">
                                Formation - {{ level.title }}
                            </a>
                            <div class="text-gray-400">
                                {{ level.chapters_count }} chapitres
                            </div>
                        </div>
                        <div v-if="level.description" class="mt-6 text-gray-500 text-justify">
                            {{ level.description }}
                        </div>
                        <div class="mt-2 flex">
                            <a class="text-blue-500 font-semibold text-justify hover:underline cursor-pointer">
                                Enregistrer les modifications
                            </a>
                            <a class="text-red-500 font-semibold text-justify hover:underline cursor-pointer ml-auto" v-on:click.prevent="removeLevel(level.uuid)">
                                Retirer la formation
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from "@/Layouts/AppLayout";

    export default {
        components: {
            AppLayout
        },

        props: ['levels'],

        data() {
            return {
                addLevel: false,
                form: {
                    title: null,
                    description: null,
                    image: null
                },
            }
        },

        watch: {
            levels: {
                handler() {
                    console.log(this.$page.flash);
                    if (this.$page.flash.toast) {
                        toastr.success(this.$page.flash.toast);
                    }
                }
            }
        },

        methods: {
            submit() {
                const formData = new FormData();
                if (this.form.title) {
                    formData.append('title', this.form.title);
                }
                if (this.form.description) {
                    formData.append('description', this.form.description);
                }
                if (this.form.image) {
                    formData.append('image', this.form.image);
                }

                this.$inertia.post('/formations', formData);
            },

            updateFile(event) {
                if (event.target.files[0].type.match("image.*")) {
                    this.form.image = event.target.files[0];

                    if (this.form.image) {
                        document.getElementById("empty").classList.add("hidden");
                    } else {
                        document.getElementById("empty").classList.remove("hidden");
                    }
                }
            },

            resetFile() {
                this.form.image = null;

                document.getElementById("empty").classList.remove("hidden");
            },

            selectFile() {
                document.getElementById("hidden-input").click();
            },

            removeLevel(uuid) {
                const formData = new FormData();
                formData.append('uuid', uuid);

                this.$inertia.post('/formation/delete', formData);
            }
        }
    }
</script>
