<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-gray-800 leading-tight">
                <a :href="route('levels.index')" class="hover:underline">
                    Les formations
                </a>
                <i class="fas fa-chevron-right fa-xs"></i>
                <a :href="'/formation/' + levelUuid" class="hover:underline">
                    {{ levelTitle | truncate(30) }}
                </a>
                <i class="fas fa-chevron-right fa-xs"></i>
                {{ chapterTitle | truncate(30) }}
            </h2>
        </template>
        <!-- TODO : Add Admin verification -->
        <div class="pt-4 max-w-7xl mx-auto sm:px-6 lg:px-8 right-0">
            <div class="flex flex-row-reverse">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" v-on:click="toggleAddCourse">
                    Ajouter un cours
                </button>
            </div>
        </div>
        <transition name="slide-fade">
            <div class="py-4" v-if="addCourse">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="w-full">
                        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" @submit.prevent="storeSubmit">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                                    Cours
                                </label>
                                <input v-if="$page.errors.titleStore" class="shadow appearance-none border border-red-700 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="title" type="text" v-model="createForm.title" placeholder="Cours">
                                <input v-else class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="title" type="text" v-model="createForm.title" placeholder="Cours">
                                <p class="text-red-700 mt-2" v-if="$page.errors.titleStore">{{ $page.errors.titleStore[0] }}</p>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                                    Description (optionnel)
                                </label>
                                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" v-model="createForm.description" placeholder="Description (optionnel)"></textarea>
                                <p class="text-red-700 mt-2" v-if="$page.errors.descriptionStore">{{ $page.errors.descriptionStore[0] }}</p>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="position">
                                    Position
                                </label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="position" v-model="createForm.position" type="number" min="0" placeholder="0">
                                <p class="text-red-700 mt-2" v-if="$page.errors.positionStore">{{ $page.errors.positionStore[0] }}</p>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">
                                    Image (optionnel)
                                </label>
                                <header class="border-dashed border-2 border-gray-400 py-12 flex flex-col justify-center items-center mb-4">
                                    <input id="hidden-input" type="file" class="hidden" v-on:change="updateFileStore">
                                    <button id="button" class="mt-2 rounded-sm text-sm px-3 py-1 bg-gray-200 hover:bg-gray-300 focus:shadow-outline focus:outline-none" @click.prevent="selectFileStore">
                                        Télécharger une image
                                    </button>
                                </header>
                                <ul id="gallery" class="flex flex-1 flex-wrap -m-1">
                                    <li v-if="!this.createForm.image" class="h-full w-full text-center flex flex-col items-center justify-center items-center">
                                        <img class="mx-auto w-32" :src="'/img/no-img.png'" alt="Aucune image sélectionnée">
                                        <span class="text-sm text-gray-500">Aucune image sélectionnée</span>
                                    </li>
                                </ul>
                                <div class="pt-4" v-if="this.createForm.image">
                                    <div class="font-semibold text-gray-700 text-sm">
                                        {{ this.createForm.image.name }} - <a href="#" v-on:click.prevent="resetFileStore" class="text-red-700 hover:underline">Supprimer</a>
                                    </div>
                                </div>
                                <p class="text-red-700 mt-2" v-if="$page.errors.imageStore">{{ $page.errors.imageStore[0] }}</p>
                            </div>
                            <div class="text-green-700 mb-4" v-if="$page.flash.successStore">
                                {{ $page.flash.successStore }}
                            </div>
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                Ajouter le cours
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </transition>
        <div class="py-4" v-for="course in $page.courses" v-bind:key="course.uuid">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-lg hover:shadow-xl sm:rounded-lg transition duration-500 ease-in-out">
                    <div v-if="course.image" class="h-20 bg-auto bg-center" :style="'background-image: url(/storage/img/courses/' + course.image + ')'"></div>
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <a v-if="course.contents_count < 1" href="#" class="text-2xl hover:underline">
                                {{ course.title }}
                            </a>
                            <a v-else :href="'/course/' + course.uuid" class="text-2xl hover:underline">
                                {{ course.title }}
                            </a>
                            <div class="text-gray-400">
                                {{ course.contents_count }} cours
                            </div>
                        </div>
                        <div class="mt-6 text-gray-500 text-justify">
                            <span v-html="course.description"></span>
                        </div>
                        <div class="mt-4 flex">
                            <a class="text-blue-500 font-semibold text-justify hover:underline cursor-pointer" v-on:click.prevent="showModal(course)">
                                Éditer le cours
                            </a>
                            <a class="text-red-500 font-semibold text-justify hover:underline cursor-pointer ml-auto" v-on:click.prevent="removeCourse(course.uuid)">
                                Retirer le cours
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="modalVisible" class="fixed overflow-hidden top-0 left-0 flex items-center justify-center w-full h-full bg-black bg-opacity-50">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 md:max-w-xl w-full" @submit.prevent="editSubmit">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="edit-title">
                        Cours
                    </label>
                    <input v-if="$page.errors.titleEdit" class="shadow appearance-none border border-red-700 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="edit-title" type="text" v-model="editForm.title" placeholder="Cours">
                    <input v-else class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="edit-title" type="text" v-model="editForm.title" placeholder="Cours">
                    <p class="text-red-700 mt-2" v-if="$page.errors.titleEdit">{{ $page.errors.titleEdit[0] }}</p>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="edit-description">
                        Description (optionnel)
                    </label>
                    <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="edit-description" v-model="editForm.description" placeholder="Description (optionnel)"></textarea>
                    <p class="text-red-700 mt-2" v-if="$page.errors.descriptionEdit">{{ $page.errors.descriptionEdit[0] }}</p>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="position">
                        Position
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="edit-position" v-model="editForm.position" type="number" min="0" placeholder="0">
                    <p class="text-red-700 mt-2" v-if="$page.errors.positionEdit">{{ $page.errors.positionEdit[0] }}</p>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Image (optionnel)
                    </label>
                    <header class="border-dashed border-2 border-gray-400 py-12 flex flex-col justify-center items-center mb-4">
                        <input id="hidden-input-edit" type="file" class="hidden" v-on:change="updateFileEdit">
                        <button id="button-edit" class="mt-2 rounded-sm text-sm px-3 py-1 bg-gray-200 hover:bg-gray-300 focus:shadow-outline focus:outline-none" @click.prevent="selectFileEdit">
                            Télécharger une image
                        </button>
                    </header>
                    <ul id="gallery-edit" class="flex flex-1 flex-wrap -m-1">
                        <li v-if="!this.editImage" class="h-full w-full text-center flex flex-col items-center justify-center items-center">
                            <img class="mx-auto w-32" :src="'/img/no-img.png'" alt="Aucune image sélectionnée">
                            <span class="text-sm text-gray-500">Aucune image sélectionnée</span>
                        </li>
                    </ul>
                    <div class="pt-4" v-if="this.editImage">
                        <div class="font-semibold text-gray-700 text-sm" v-if="this.editImage.name">
                            {{ this.editImage.name }} - <a href="#" v-on:click.prevent="resetFileEdit" class="text-red-700 hover:underline">Supprimer</a>
                        </div>
                        <div class="font-semibold text-gray-700 text-sm" v-else>
                            {{ this.editImage }} - <a href="#" v-on:click.prevent="resetFileEdit" class="text-red-700 hover:underline">Supprimer</a>
                        </div>
                    </div>
                    <p class="text-red-700 mt-2" v-if="$page.errors.imageEdit">{{ $page.errors.imageEdit[0] }}</p>
                </div>
                <div class="text-green-700" v-if="$page.flash.successEdit">
                    {{ $page.flash.successEdit }}
                </div>
                <div class="mt-4">
                    <span class="flex w-full rounded">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                            Enregistrer
                        </button>
                        <button v-on:click="closeModal" class="ml-auto bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
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

    props: ['courses', 'chapter', 'level'],

    data() {
        return {
            chapterTitle: this.chapter.title,
            chapterUuid: this.chapter.uuid,
            levelTitle: this.level.title,
            levelUuid: this.level.uuid,
            addCourse: false,
            modalVisible: false,
            createForm: {
                title: null,
                description: null,
                position: null,
                image: null
            },
            editForm: {
                uuid: null,
                title: null,
                description: null,
                position: null
            },
            editImage: null
        }
    },

    watch: {
        courses: {
            handler() {
                if (this.$page.flash.toast) {
                    toastr.success(this.$page.flash.toast);
                }
            }
        }
    },

    methods: {
        toggleAddCourse() {
            this.addCourse = !this.addCourse;

            this.clearFormMessages();
        },

        storeSubmit() {
            const formData = new FormData();
            if (this.createForm.title) {
                formData.append('titleStore', this.createForm.title);
            }
            if (this.createForm.description) {
                formData.append('descriptionStore', this.createForm.description);
            }
            if (this.createForm.position) {
                formData.append('positionStore', this.createForm.position);
            }
            if (this.createForm.image) {
                formData.append('imageStore', this.createForm.image);
            }
            formData.append('chapterUuid', this.chapterUuid);

            this.$inertia.post('/course/store', formData);
        },

        updateFileStore(event) {
            if (event.target.files[0].type.match("image.*")) {
                this.createForm.image = event.target.files[0];
            }
        },

        resetFileStore() {
            this.createForm.image = null;
        },

        selectFileStore() {
            document.getElementById("hidden-input").click();
        },

        removeCourse(uuid) {
            const formData = new FormData();
            formData.append('uuid', uuid);
            formData.append('chapterUuid', this.chapterUuid);

            this.$inertia.post('/course/delete', formData);
        },

        showModal(course) {
            this.updateEditForm(course);

            this.modalVisible = true;
        },

        closeModal() {
            this.modalVisible = false;

            this.updateEditForm(null);
            this.clearFormMessages();
        },

        editSubmit() {
            const formData = new FormData();
            if (this.editForm.uuid) {
                formData.append('uuid', this.editForm.uuid);
            }
            if (this.editForm.title) {
                formData.append('titleEdit', this.editForm.title);
            }
            if (this.editForm.description) {
                formData.append('descriptionEdit', this.editForm.description);
            }
            if (this.editForm.position) {
                formData.append('positionEdit', this.editForm.position);
            }
            if (this.editImage) {
                formData.append('imageEdit', this.editImage);
            }
            formData.append('chapterUuid', this.chapterUuid);

            this.$inertia.post('/course/edit', formData);
        },

        updateFileEdit(event) {
            if (event.target.files[0].type.match("image.*")) {
                this.editImage = event.target.files[0];
            }
        },

        resetFileEdit() {
            this.editImage = null;
        },

        selectFileEdit() {
            document.getElementById("hidden-input-edit").click();
        },

        updateEditForm(course) {
            this.editForm.uuid = course ? course.uuid : null;
            this.editForm.title = course ? course.title : null;
            this.editForm.description = course ? course.description : null;
            this.editForm.position = course ? course.position : null;
            this.editImage = course ? course.image : null;
        },

        clearFormMessages() {
            this.$page.errors = {};
            this.$page.flash = {};
        }
    }
}
</script>
