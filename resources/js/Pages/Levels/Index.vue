<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Les formations
            </h2>
        </template>
        <div class="py-4 max-w-7xl mx-auto sm:px-6 lg:px-8 right-0">
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
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="title" type="text" v-model="form.title" placeholder="Niveau de formation">
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                                    Description (optionnel)
                                </label>
                                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" v-model="form.description" placeholder="Description (optionnel)"></textarea>
                            </div>
                            <!-- TODO : Update Image field -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="image">
                                    Image
                                </label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="image" type="text" v-model="form.image" placeholder="Image">
                            </div>
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                Ajouter la formation
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </transition>
        <div class="py-4" v-for="level in this.levelList" v-bind:key="level.id">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-lg hover:shadow-xl sm:rounded-lg transition duration-500 ease-in-out">
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <a v-if="level.chapters_count < 1" href="#" v-on:click.prevent="notification('Formation vide.')" class="text-2xl hover:underline">
                                Formation - {{ level.title }}
                            </a>
                            <a v-else :href="'/niveau/' + level.uuid" class="text-2xl hover:underline">
                                Formation - {{ level.title }}
                            </a>
                            <div class="text-gray-400">
                                {{ level.chapters_count }} chapitres
                            </div>
                        </div>
                        <div class="mt-6 text-gray-500 text-justify">
                            {{ level.description }}
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
                levelList: this.levels,
                form: {
                    title: null,
                    description: null,
                    image: null
                },
                addLevel: false
            }
        },

        methods: {
            submit() {
                axios.post('/formations', {
                    title: this.form.title,
                    description: this.form.description,
                    image: this.form.image
                })
                .then(response => {
                    this.levelList = response.data;
                    toastr.success('Formation en ligne!');
                })
                .catch(error => toastr.error(error));
            },
            notification(message) {
                toastr.warning(message);
            }
        }
    }
</script>
