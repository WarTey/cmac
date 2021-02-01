<template>
    <app-layout :showingHeader="true" :sidebarItems="sidebarItems">
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
                <a :href="'/chapitre/' + chapterUuid" class="hover:underline">
                    {{ chapterTitle | truncate(30) }}
                </a>
                <i class="fas fa-chevron-right fa-xs"></i>
                {{ courseTitle | truncate(30) }}
            </h2>
        </template>
        <div v-if="$page.user && $page.user.admin" class="pt-4 max-w-7xl mx-auto sm:px-6 lg:px-8 right-0">
            <div class="flex flex-row-reverse">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" v-on:click="toggleAddContent">
                    Ajouter un contenu
                </button>
            </div>
        </div>
        <div v-if="$page.user && $page.user.admin" class="pt-4 max-w-7xl mx-auto sm:px-6 lg:px-8 right-0">
            <div class="flex flex-row-reverse">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" v-on:click="toggleAddResource">
                    Ajouter une ressource
                </button>
            </div>
        </div>
        <transition name="slide-fade">
            <div class="py-4" v-if="$page.user && $page.user.admin && addContent">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="w-full">
                        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" @submit.prevent="storeContentSubmit">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                                    Contenu
                                </label>
                                <input v-if="$page.errors.titleStore" class="shadow appearance-none border border-red-700 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="title" type="text" v-model="createForm.title" placeholder="Contenu">
                                <input v-else class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="title" type="text" v-model="createForm.title" placeholder="Contenu">
                                <p class="text-red-700 mt-2" v-if="$page.errors.titleStore">{{ $page.errors.titleStore[0] }}</p>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="position">
                                    Position
                                </label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="position" v-model="createForm.position" type="number" min="0" placeholder="0">
                                <p class="text-red-700 mt-2" v-if="$page.errors.positionStore">{{ $page.errors.positionStore[0] }}</p>
                            </div>
                            <div class="text-green-700 mb-4" v-if="$page.flash.successStore">
                                {{ $page.flash.successStore }}
                            </div>
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                Ajouter le contenu
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="py-4" v-if="$page.user && $page.user.admin && addResource">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="w-full">
                        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" @submit.prevent="storeResourceSubmit">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                                    Description (optionnel)
                                </label>
                                <editor id="description" v-model="createForm.description" placeholder="Description (optionnel)"
                                    apiKey="528024vvgynnj3f3bkog3rccyp4a597mjw1nt6bs69bxvg1p"
                                    :init="{
                                        height: 200,
                                        menubar: true,
                                        plugins: [
                                            'advlist autolink lists link image charmap',
                                            'searchreplace visualblocks code fullscreen',
                                            'print preview anchor insertdatetime media',
                                            'paste code help wordcount table'
                                        ],
                                        toolbar:
                                            'undo redo | formatselect | bold italic underline | \
                                            fontsizeselect forecolor | \
                                            alignleft aligncenter alignright | \
                                            bullist numlist outdent indent | help'
                                    }">
                                </editor>
                                <p class="text-red-700 mt-2" v-if="$page.errors.descriptionStore">{{ $page.errors.descriptionStore[0] }}</p>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="position">
                                    Position
                                </label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="position" v-model="createForm.position" type="number" min="0" placeholder="0">
                                <p class="text-red-700 mt-2" v-if="$page.errors.positionStore">{{ $page.errors.positionStore[0] }}</p>
                            </div>
                            <div class="mb-2 flex flex-col">
                                <label>
                                    <input type="radio" class="form-radio" name="accountType" value="0" v-model="createForm.option">
                                    <span class="ml-2">Comportement normal</span>
                                </label>
                                <label>
                                    <input type="radio" class="form-radio" name="accountType" value="1" v-model="createForm.option">
                                    <span class="ml-2">Supprimer le cours à la même position</span>
                                </label>
                                <label>
                                    <input type="radio" class="form-radio" name="accountType" value="2" v-model="createForm.option">
                                    <span class="ml-2">Décaler le cours à la même position</span>
                                </label>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">
                                    PDF (optionnel)
                                </label>
                                <header class="border-dashed border-2 border-gray-400 py-12 flex flex-col justify-center items-center mb-4">
                                    <input id="hidden-input-file" type="file" class="hidden" v-on:change="updateFileStore">
                                    <button id="button-store" class="mt-2 rounded-sm text-sm px-3 py-1 bg-gray-200 hover:bg-gray-300 focus:shadow-outline focus:outline-none" @click.prevent="selectFileStore">
                                        Télécharger un PDF
                                    </button>
                                </header>
                                <ul id="gallery-store" class="flex flex-1 flex-wrap -m-1">
                                    <li v-if="!this.createForm.file" class="h-full w-full text-center flex flex-col items-center justify-center items-center">
                                        <img class="mx-auto w-32" :src="'/img/no-img.png'" alt="Aucune image sélectionnée">
                                        <span class="text-sm text-gray-500">Aucun PDF sélectionné</span>
                                    </li>
                                </ul>
                                <div class="pt-4" v-if="this.createForm.file">
                                    <div class="font-semibold text-gray-700 text-sm">
                                        {{ this.createForm.file.name }} - <a href="#" v-on:click.prevent="resetFileStore" class="text-red-700 hover:underline">Supprimer</a>
                                    </div>
                                </div>
                                <p class="text-red-700 mt-2" v-if="$page.errors.fileStore">{{ $page.errors.fileStore[0] }}</p>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">
                                    Vidéo (optionnelle)
                                </label>
                                <header class="border-dashed border-2 border-gray-400 py-12 flex flex-col justify-center items-center mb-4">
                                    <input id="hidden-input-video" type="file" class="hidden" v-on:change="updateVideoStore">
                                    <button id="button-store-video" class="mt-2 rounded-sm text-sm px-3 py-1 bg-gray-200 hover:bg-gray-300 focus:shadow-outline focus:outline-none" @click.prevent="selectVideoStore">
                                        Télécharger une vidéo
                                    </button>
                                </header>
                                <ul id="gallery-store-video" class="flex flex-1 flex-wrap -m-1">
                                    <li v-if="!this.createForm.video" class="h-full w-full text-center flex flex-col items-center justify-center items-center">
                                        <img class="mx-auto w-32" :src="'/img/no-img.png'" alt="Aucune image sélectionnée">
                                        <span class="text-sm text-gray-500">Aucune vidéo sélectionnée</span>
                                    </li>
                                </ul>
                                <div class="pt-4" v-if="this.createForm.video">
                                    <div class="font-semibold text-gray-700 text-sm">
                                        {{ this.createForm.video.name }} - <a href="#" v-on:click.prevent="resetVideoStore" class="text-red-700 hover:underline">Supprimer</a>
                                    </div>
                                </div>
                                <p class="text-red-700 mt-2" v-if="$page.errors.videoStore">{{ $page.errors.videoStore[0] }}</p>
                            </div>
                            <div class="text-green-700 mb-4" v-if="$page.flash.successStore">
                                {{ $page.flash.successStore }}
                            </div>
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                Ajouter la resource
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </transition>
        <div class="pt-4" v-if="$page.contents.length > 0">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <progress-bar :name="$page.contents[contentIndex].title" :contents="$page.contents" :contentIndex="contentIndex" @updateContentIndex="updateContentIndex" />
            </div>
        </div>
        <div class="py-4" v-if="$page.contents.length > 0">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-lg hover:shadow-xl rounded-lg transition duration-500 ease-in-out">
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        <div v-for="(resource, index) in $page.contents[contentIndex].resources" v-bind:key="resource.uuid">
                            <div :class="{'mt-6': index > 0}" v-if="resource.description">
                                <span v-html="resource.description"></span>
                            </div>
                            <div class="mt-6" v-if="resource.file">
                                <iframe :src="'/storage/files/' + resource.file" width="100%" height="500px"></iframe>
                            </div>
                            <div class="mt-6" v-if="resource.video">
                                <video width="100%" height="500px" controls>
                                    <!-- TODO : Change video format -->
                                    <source :src="'/storage/videos/' + resource.video" type=video/quicktime>
                                </video>
                            </div>
                            <div v-if="$page.user && $page.user.admin" class="mt-4 flex">
                                <a class="text-blue-500 font-semibold text-justify hover:underline cursor-pointer" v-on:click.prevent="showEditResource(resource)">
                                    Éditer la ressource
                                </a>
                                <a class="text-red-500 font-semibold text-justify hover:underline cursor-pointer ml-auto" v-on:click.prevent="removeResource(resource.uuid)">
                                    Retirer la ressource
                                </a>
                            </div>
                        </div>
                        <div v-if="$page.user && $page.user.admin" class="mt-4 flex">
                            <a class="text-blue-500 font-semibold text-justify hover:underline cursor-pointer" v-on:click.prevent="showEditContent($page.contents[contentIndex])">
                                Éditer le contenu
                            </a>
                            <a class="text-red-500 font-semibold text-justify hover:underline cursor-pointer ml-auto" v-on:click.prevent="removeContent($page.contents[contentIndex].uuid)">
                                Retirer le contenu
                            </a>
                        </div>
                    </div>
                </div>
                <div class="pt-5 text-center flex">
                    <button v-if="$page.contents[contentIndex].profiles_count === 0" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ml-auto" v-on:click="editCompleted($page.contents[contentIndex])">
                        J'ai terminé
                    </button>
                    <button v-else class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ml-auto" v-on:click="editCompleted($page.contents[contentIndex])">
                        Je n'ai pas terminé
                    </button>
                </div>
                <div class="py-5 text-center flex" v-if="contentIndex > 0 || contentIndex < $page.contents.length - 1">
                    <button v-if="contentIndex > 0" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" v-on:click="contentIndex -= 1">
                        <i class="fas fa-chevron-left fa-xs"></i>
                        Contenu précédent
                    </button>
                    <button v-if="contentIndex < $page.contents.length - 1" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ml-auto" v-on:click="contentIndex += 1">
                        Contenu suivant
                        <i class="fas fa-chevron-right fa-xs"></i>
                    </button>
                </div>
            </div>
        </div>
        <div v-if="$page.user && $page.user.admin && editContent" class="fixed overflow-hidden top-0 left-0 flex items-center justify-center w-full h-full bg-black bg-opacity-50">
            <form class="bg-white shadow-md rounded px-8 md:max-w-xl w-full max-h-4/5 overflow-auto" @submit.prevent="editContentSubmit">
                <div class="mb-4 mt-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="edit-title">
                        Contenu
                    </label>
                    <input v-if="$page.errors.titleEdit" class="shadow appearance-none border border-red-700 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="edit-title" type="text" v-model="editForm.title" placeholder="Contenu">
                    <input v-else class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="edit-title" type="text" v-model="editForm.title" placeholder="Contenu">
                    <p class="text-red-700 mt-2" v-if="$page.errors.titleEdit">{{ $page.errors.titleEdit[0] }}</p>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="position">
                        Position
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="edit-position" v-model="editForm.position" type="number" min="0" placeholder="0">
                    <p class="text-red-700 mt-2" v-if="$page.errors.positionEdit">{{ $page.errors.positionEdit[0] }}</p>
                </div>
                <div class="text-green-700" v-if="$page.flash.successEdit">
                    {{ $page.flash.successEdit }}
                </div>
                <div class="mt-4 mb-6">
                    <span class="flex w-full rounded">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                            Enregistrer
                        </button>
                        <button v-on:click="closeEditContent" class="ml-auto bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Fermer
                        </button>
                    </span>
                </div>
            </form>
        </div>
        <div v-if="$page.user && $page.user.admin && editResource" class="fixed overflow-hidden top-0 left-0 flex items-center justify-center w-full h-full bg-black bg-opacity-50">
            <form class="bg-white shadow-md rounded px-8 md:max-w-xl w-full max-h-4/5 overflow-auto" @submit.prevent="editResourceSubmit">
                <div class="mb-4 mt-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="edit-description">
                        Description (optionnel)
                    </label>
                    <editor id="edit-description" v-model="editForm.description" placeholder="Description (optionnel)"
                        apiKey="528024vvgynnj3f3bkog3rccyp4a597mjw1nt6bs69bxvg1p"
                        :init="{
                            height: 200,
                            menubar: true,
                            plugins: [
                                'advlist autolink lists link image charmap',
                                'searchreplace visualblocks code fullscreen',
                                'print preview anchor insertdatetime media',
                                'paste code help wordcount table'
                            ],
                            toolbar:
                                'undo redo | formatselect | bold italic underline | \
                                fontsizeselect forecolor | \
                                alignleft aligncenter alignright | \
                                bullist numlist outdent indent | help'
                        }">
                    </editor>
                    <p class="text-red-700 mt-2" v-if="$page.errors.descriptionEdit">{{ $page.errors.descriptionEdit[0] }}</p>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="position">
                        Position
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="edit-position-resource" v-model="editForm.position" type="number" min="0" placeholder="0">
                    <p class="text-red-700 mt-2" v-if="$page.errors.positionEdit">{{ $page.errors.positionEdit[0] }}</p>
                </div>
                <div class="mb-2 flex flex-col">
                    <label>
                        <input type="radio" class="form-radio" name="accountType" value="0" v-model="editForm.option">
                        <span class="ml-2">Comportement normal</span>
                    </label>
                    <label>
                        <input type="radio" class="form-radio" name="accountType" value="1" v-model="editForm.option">
                        <span class="ml-2">Supprimer le cours à la même position</span>
                    </label>
                    <label>
                        <input type="radio" class="form-radio" name="accountType" value="2" v-model="editForm.option">
                        <span class="ml-2">Décaler le cours à la même position</span>
                    </label>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        PDF (optionnel)
                    </label>
                    <header class="border-dashed border-2 border-gray-400 py-12 flex flex-col justify-center items-center mb-4">
                        <input id="hidden-input-file-edit" type="file" class="hidden" v-on:change="updateFileEdit">
                        <button id="button-file-edit" class="mt-2 rounded-sm text-sm px-3 py-1 bg-gray-200 hover:bg-gray-300 focus:shadow-outline focus:outline-none" @click.prevent="selectFileEdit">
                            Télécharger un PDF
                        </button>
                    </header>
                    <ul id="gallery-file-edit" class="flex flex-1 flex-wrap -m-1">
                        <li v-if="!editFile" class="h-full w-full text-center flex flex-col items-center justify-center items-center">
                            <img class="mx-auto w-32" :src="'/img/no-img.png'" alt="Aucun PDF sélectionné">
                            <span class="text-sm text-gray-500">Aucun PDF sélectionné</span>
                        </li>
                    </ul>
                    <div class="pt-4" v-if="editFile">
                        <div class="font-semibold text-gray-700 text-sm" v-if="editFile.name">
                            {{ editFile.name }} - <a href="#" v-on:click.prevent="resetFileEdit" class="text-red-700 hover:underline">Supprimer</a>
                        </div>
                        <div class="font-semibold text-gray-700 text-sm" v-else>
                            {{ editFile }} - <a href="#" v-on:click.prevent="resetFileEdit" class="text-red-700 hover:underline">Supprimer</a>
                        </div>
                    </div>
                    <p class="text-red-700 mt-2" v-if="$page.errors.imageEdit">{{ $page.errors.imageEdit[0] }}</p>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Vidéo (optionnelle)
                    </label>
                    <header class="border-dashed border-2 border-gray-400 py-12 flex flex-col justify-center items-center mb-4">
                        <input id="hidden-input-video-edit" type="file" class="hidden" v-on:change="updateVideoEdit">
                        <button id="button-video-edit" class="mt-2 rounded-sm text-sm px-3 py-1 bg-gray-200 hover:bg-gray-300 focus:shadow-outline focus:outline-none" @click.prevent="selectVideoEdit">
                            Télécharger une vidéo
                        </button>
                    </header>
                    <ul id="gallery-video-edit" class="flex flex-1 flex-wrap -m-1">
                        <li v-if="!editVideo" class="h-full w-full text-center flex flex-col items-center justify-center items-center">
                            <img class="mx-auto w-32" :src="'/img/no-img.png'" alt="Aucune Vidéo sélectionnée">
                            <span class="text-sm text-gray-500">Aucune Vidéo sélectionnée</span>
                        </li>
                    </ul>
                    <div class="pt-4" v-if="editVideo">
                        <div class="font-semibold text-gray-700 text-sm" v-if="editVideo.name">
                            {{ editVideo.name }} - <a href="#" v-on:click.prevent="resetVideoEdit" class="text-red-700 hover:underline">Supprimer</a>
                        </div>
                        <div class="font-semibold text-gray-700 text-sm" v-else>
                            {{ editVideo }} - <a href="#" v-on:click.prevent="resetVideoEdit" class="text-red-700 hover:underline">Supprimer</a>
                        </div>
                    </div>
                    <p class="text-red-700 mt-2" v-if="$page.errors.imageEdit">{{ $page.errors.imageEdit[0] }}</p>
                </div>
                <div class="text-green-700" v-if="$page.flash.successEdit">
                    {{ $page.flash.successEdit }}
                </div>
                <div class="mt-4 mb-6">
                    <span class="flex w-full rounded">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                            Enregistrer
                        </button>
                        <button v-on:click="closeEditResource" class="ml-auto bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
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
import ProgressBar from "@/Pages/Contents/ProgressBar";
import Editor from '@tinymce/tinymce-vue';
import PdfViewer from "@/Pages/Contents/PdfViewer";

export default {
    components: {
        AppLayout,
        ProgressBar,
        editor: Editor,
        PdfViewer
    },

    props: ['contents', 'course', 'chapter', 'level', 'progression', 'sidebarItems'],

    data() {
        return {
            courseTitle: this.course.title,
            courseUuid: this.course.uuid,
            chapterTitle: this.chapter.title,
            chapterUuid: this.chapter.uuid,
            levelTitle: this.level.title,
            levelUuid: this.level.uuid,
            addContent: false,
            addResource: false,
            editContent: false,
            editResource: false,
            contentIndex: 0,
            createForm: {
                title: null,
                description: null,
                file: null,
                video: null,
                position: null,
                option: null
            },
            editForm: {
                uuid: null,
                title: null,
                description: null,
                file: null,
                video: null,
                position: null,
                option: null
            },
            editFile: null,
            editVideo: null
        }
    },

    watch: {
        contents: {
            handler() {
                if (this.$page.flash.toast) {
                    toastr.success(this.$page.flash.toast);
                }
            }
        }
    },

    methods: {
        toggleAddContent() {
            if (this.addResource) {
                this.addResource = !this.addResource;
            }
            this.addContent = !this.addContent;

            this.clearFormMessages();
        },

        toggleAddResource() {
            if (this.addContent) {
                this.addContent = !this.addContent;
            }
            this.addResource = !this.addResource;

            this.clearFormMessages();
        },

        storeContentSubmit() {
            const formData = new FormData();
            if (this.createForm.title) {
                formData.append('titleStore', this.createForm.title);
            }
            if (this.createForm.position) {
                formData.append('positionStore', this.createForm.position);
            }
            formData.append('courseUuid', this.courseUuid);

            this.$inertia.post('/content/store', formData);
        },

        storeResourceSubmit() {
            const formData = new FormData();
            if (this.createForm.description) {
                formData.append('descriptionStore', this.createForm.description);
            }
            if (this.createForm.file) {
                formData.append('fileStore', this.createForm.file);
            }
            if (this.createForm.video) {
                formData.append('videoStore', this.createForm.video);
            }
            if (this.createForm.position) {
                formData.append('positionStore', this.createForm.position);
            }
            if (this.createForm.option) {
                formData.append('optionStore', this.createForm.option);
            }
            formData.append('contentUuid', this.contents[this.contentIndex].uuid);
            formData.append('courseUuid', this.courseUuid);

            this.$inertia.post('/resource/store', formData);
        },

        updateFileStore(event) {
            if (event.target.files[0].type.match("application/pdf")) {
                this.createForm.file = event.target.files[0];
            }
        },

        resetFileStore() {
            this.createForm.file = null;
        },

        selectFileStore() {
            document.getElementById("hidden-input-file").click();
        },

        updateVideoStore(event) {
            // TODO : Change video format
            if (event.target.files[0].type.match("video/quicktime")) {
                this.createForm.video = event.target.files[0];
            }
        },

        resetVideoStore() {
            this.createForm.video = null;
        },

        selectVideoStore() {
            document.getElementById("hidden-input-video").click();
        },

        removeContent(uuid) {
            const formData = new FormData();
            formData.append('uuid', uuid);
            formData.append('courseUuid', this.courseUuid);

            this.$inertia.post('/content/delete', formData);
        },

        showEditContent(content) {
            this.updateEditForm(content);

            if (this.editResource) {
                this.editResource = false;
            }
            this.editContent = true;
        },

        closeEditContent() {
            this.editContent = false;

            this.updateEditForm(null);
            this.clearFormMessages();
        },

        editContentSubmit() {
            const formData = new FormData();
            if (this.editForm.uuid) {
                formData.append('uuid', this.editForm.uuid);
            }
            if (this.editForm.title) {
                formData.append('titleEdit', this.editForm.title);
            }
            if (this.editForm.position) {
                formData.append('positionEdit', this.editForm.position);
            }
            formData.append('courseUuid', this.courseUuid);

            this.$inertia.post('/content/edit', formData);
        },

        removeResource(uuid) {
            const formData = new FormData();
            formData.append('uuid', uuid);
            formData.append('courseUuid', this.courseUuid);

            this.$inertia.post('/resource/delete', formData);
        },

        showEditResource(resource) {
            this.updateEditForm(resource);

            if (this.editContent) {
                this.editContent = false;
            }
            this.editResource = true;
        },

        closeEditResource() {
            this.editResource = false;

            this.updateEditForm(null);
            this.clearFormMessages();
        },

        editResourceSubmit() {
            const formData = new FormData();
            if (this.editForm.uuid) {
                formData.append('uuid', this.editForm.uuid);
            }
            if (this.editForm.description) {
                formData.append('descriptionEdit', this.editForm.description);
            }
            if (this.editFile) {
                formData.append('fileEdit', this.editFile);
            }
            if (this.editVideo) {
                formData.append('videoEdit', this.editVideo);
            }
            if (this.editForm.position) {
                formData.append('positionEdit', this.editForm.position);
            }
            if (this.editForm.option) {
                formData.append('optionEdit', this.editForm.option);
            }
            formData.append('courseUuid', this.courseUuid);

            this.$inertia.post('/resource/edit', formData);
        },

        updateFileEdit(event) {
            if (event.target.files[0].type.match("application/pdf")) {
                this.editFile = event.target.files[0];
            }
        },

        resetFileEdit() {
            this.editFile = null;
        },

        selectFileEdit() {
            document.getElementById("hidden-input-file-edit").click();
        },

        updateVideoEdit(event) {
            if (event.target.files[0].type.match("video/quicktime")) {
                this.editVideo = event.target.files[0];
            }
        },

        resetVideoEdit() {
            this.editVideo = null;
        },

        selectVideoEdit() {
            document.getElementById("hidden-input-video-edit").click();
        },

        updateEditForm(content) {
            this.editForm.uuid = content && content.uuid ? content.uuid : null;
            this.editForm.title = content && content.title ? content.title : null;
            this.editForm.description = content && content.description ? content.description : null;
            this.editForm.position = content && content.position ? content.position : null;
            this.editForm.option = content && content.option ? content.option : null;
            this.editFile = content && content.file ? content.file : null;
            this.editVideo = content && content.video ? content.video : null;
        },

        clearFormMessages() {
            this.$page.errors = {};
            this.$page.flash = {};
        },

        updateContentIndex(index) {
            this.contentIndex = index;
        },

        editCompleted(content) {
            const formData = new FormData();
            formData.append('contentUuid', content.uuid);
            formData.append('courseUuid', this.courseUuid);

            this.$inertia.post(content.profiles_count > 0 ? '/completed/delete' : '/completed/edit', formData);
        }
    }
}
</script>
