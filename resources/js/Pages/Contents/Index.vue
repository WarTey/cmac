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
                <a :href="'/chapter/' + chapterUuid" class="hover:underline">
                    {{ chapterTitle | truncate(30) }}
                </a>
                <i class="fas fa-chevron-right fa-xs"></i>
                {{ courseTitle | truncate(30) }}
            </h2>
        </template>
        <!-- TODO : Add Admin verification -->
        <div class="pt-4 max-w-7xl mx-auto sm:px-6 lg:px-8 right-0">
            <div class="flex flex-row-reverse">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" v-on:click="toggleAddContent">
                    Ajouter un contenu
                </button>
            </div>
        </div>
        <transition name="slide-fade">
            <div class="py-4" v-if="addContent">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="w-full">
                        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" @submit.prevent="storeSubmit">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                                    Contenu
                                </label>
                                <input v-if="$page.errors.titleStore" class="shadow appearance-none border border-red-700 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="title" type="text" v-model="createForm.title" placeholder="Contenu">
                                <input v-else class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="title" type="text" v-model="createForm.title" placeholder="Contenu">
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
                                    PDF (optionnel)
                                </label>
                                <header class="border-dashed border-2 border-gray-400 py-12 flex flex-col justify-center items-center mb-4">
                                    <input id="hidden-input" type="file" multiple class="hidden" v-on:change="updateFileStore">
                                    <button id="button" class="mt-2 rounded-sm text-sm px-3 py-1 bg-gray-200 hover:bg-gray-300 focus:shadow-outline focus:outline-none" @click.prevent="selectFileStore">
                                        Télécharger un PDF
                                    </button>
                                </header>
                                <ul id="gallery" class="flex flex-1 flex-wrap -m-1">
                                    <li v-if="this.createForm.files.length === 0" class="h-full w-full text-center flex flex-col items-center justify-center items-center">
                                        <img class="mx-auto w-32" :src="'/img/no-img.png'" alt="Aucun PDF sélectionné">
                                        <span class="text-sm text-gray-500">Aucun PDF sélectionné</span>
                                    </li>
                                </ul>
                                <div class="pt-4" v-for="(file, index) in this.createForm.files" v-bind:key="file.name + index">
                                    <div class="font-semibold text-gray-700 text-sm">
                                        {{ file.name }} - <a href="#" v-on:click.prevent="resetFileStore(index)" class="text-red-700 hover:underline">Supprimer</a>
                                    </div>
                                    <p class="text-red-700 mt-2" v-if="$page.errors.hasOwnProperty('filesStore.' + index)">
                                        Format du fichier ou taille incorrect.
                                    </p>
                                </div>
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
        </transition>
        <div class="py-4" v-for="content in $page.contents" v-bind:key="content.uuid">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-lg hover:shadow-xl sm:rounded-lg transition duration-500 ease-in-out">
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <div class="text-2xl">
                                {{ content.title }}
                            </div>
                        </div>
                        <div class="mt-6 text-gray-500 text-justify">
                            {{ content.description }}
                        </div>
                        <div class="mt-6" v-for="file in content.files" v-bind:key="file.uuid">
                            <canvas class="w-full rounded border" :id="file.uuid">{{ loadFile(file.title, file.uuid) }}</canvas>
                            <div class="mt-2 flex">
                                <a class="text-blue-500 font-semibold text-justify hover:underline cursor-pointer" v-on:click.prevent="previousPage(file.uuid)">
                                    Page précédente
                                </a>
                                <a class="text-blue-500 font-semibold text-justify hover:underline cursor-pointer ml-auto" v-on:click.prevent="nextPage(file.uuid)">
                                    Page suivante
                                </a>
                            </div>
                        </div>
                        <div class="mt-4 flex">
                            <a class="text-blue-500 font-semibold text-justify hover:underline cursor-pointer" v-on:click.prevent="showModal(content)">
                                Éditer le contenu
                            </a>
                            <a class="text-red-500 font-semibold text-justify hover:underline cursor-pointer ml-auto" v-on:click.prevent="removeContent(content.uuid)">
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
                        Contenu
                    </label>
                    <input v-if="$page.errors.titleEdit" class="shadow appearance-none border border-red-700 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="edit-title" type="text" v-model="editForm.title" placeholder="Contenu">
                    <input v-else class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="edit-title" type="text" v-model="editForm.title" placeholder="Contenu">
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
                        PDF (optionnel)
                    </label>
                    <header class="border-dashed border-2 border-gray-400 py-12 flex flex-col justify-center items-center mb-4">
                        <input id="hidden-input-edit" type="file" multiple class="hidden" v-on:change="updateFileEdit">
                        <button id="button-edit" class="mt-2 rounded-sm text-sm px-3 py-1 bg-gray-200 hover:bg-gray-300 focus:shadow-outline focus:outline-none" @click.prevent="selectFileEdit">
                            Télécharger un PDF
                        </button>
                    </header>
                    <ul id="gallery-edit" class="flex flex-1 flex-wrap -m-1">
                        <li v-if="this.saveFiles.length === 0 && this.addFiles.length === 0" class="h-full w-full text-center flex flex-col items-center justify-center items-center">
                            <img class="mx-auto w-32" :src="'/img/no-img.png'" alt="Aucun PDF sélectionné">
                            <span class="text-sm text-gray-500">Aucun PDF sélectionné</span>
                        </li>
                    </ul>
                    <div class="pt-4" v-for="(file, index) in this.saveFiles" v-bind:key="file.name + index">
                        <div class="font-semibold text-gray-700 text-sm">
                            {{ file.name }} - <a href="#" v-on:click.prevent="resetFileSave(index)" class="text-red-700 hover:underline">Supprimer</a>
                        </div>
                        <p class="text-red-700 mt-2" v-if="$page.errors.hasOwnProperty('filesSave.' + index)">
                            Format du fichier ou taille incorrect.
                        </p>
                    </div>
                    <div class="pt-4" v-for="(file, index) in this.addFiles" v-bind:key="file.name + index">
                        <div class="font-semibold text-gray-700 text-sm">
                            {{ file.name }} - <a href="#" v-on:click.prevent="resetFileAdd(index)" class="text-red-700 hover:underline">Supprimer</a>
                        </div>
                        <p class="text-red-700 mt-2" v-if="$page.errors.hasOwnProperty('filesAdd.' + index)">
                            Format du fichier ou taille incorrect.
                        </p>
                    </div>
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

    props: ['contents', 'course', 'chapter', 'level'],

    data() {
        return {
            courseTitle: this.course.title,
            courseUuid: this.course.uuid,
            chapterTitle: this.chapter.title,
            chapterUuid: this.chapter.uuid,
            levelTitle: this.level.title,
            levelUuid: this.level.uuid,
            addContent: false,
            modalVisible: false,
            createForm: {
                title: null,
                description: null,
                position: null,
                files: []
            },
            files: [],
            editForm: {
                uuid: null,
                title: null,
                description: null,
                position: null
            },
            delFiles: [],
            addFiles: [],
            saveFiles: []
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
            this.addContent = !this.addContent;

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
            if (this.createForm.files.length > 0) {
                this.createForm.files.forEach(element =>
                    formData.append('filesStore[]', element)
                );
            }
            formData.append('courseUuid', this.courseUuid);

            this.$inertia.post('/content/store', formData);
        },

        updateFileStore(event) {
            if (event.target.files[0].type.match("application/pdf")) {
                this.createForm.files.push(event.target.files[0]);
            }
        },

        resetFileStore(index) {
            this.createForm.files.splice(index, 1);
        },

        selectFileStore() {
            document.getElementById("hidden-input").click();
        },

        loadFile(url, uuid) {
            pdfjsLib.disableWorker = true;
            pdfjsLib.getDocument({
                url : "/storage/files/" + url,
                disableAutoFetch: true,
                disableStream: true
            }).promise.then(pdf => {

                this.files.push({
                    uuid: uuid,
                    pdf: pdf,
                    pages: pdf.numPages,
                    currentPage: 1
                });

                pdf.getPage(1).then(page => this.renderFile(page, uuid));
            });
        },

        renderFile(page, uuid) {
            const canvas = document.getElementById(uuid);
            const context = canvas.getContext('2d');
            const viewport = page.getViewport({
                scale: 2,
                rotation: 0
            });

            canvas.height = viewport.height;
            canvas.width = viewport.width;

            page.render({
                canvasContext: context,
                viewport: viewport
            });
        },

        getPageStatus(uuid) {
            this.files.forEach(element => {
                if (element.uuid === uuid) {
                    return element.currentPage + " / " + element.pages;
                }
            });
        },

        nextPage(uuid) {
            if (this.files.length > 0) {
                this.files.forEach(element => {
                    if (element.uuid === uuid && element.currentPage < element.pages) {
                        element.currentPage += 1;
                        element.pdf.getPage(element.currentPage).then(page => this.renderFile(page, uuid));
                    }
                });
            }
        },

        previousPage(uuid) {
            this.files.forEach(element => {
                if (element.uuid === uuid && element.currentPage > 0) {
                    element.currentPage -= 1;
                    element.pdf.getPage(element.currentPage).then(page => this.renderFile(page, uuid));
                }
            });
        },

        removeContent(uuid) {
            const formData = new FormData();
            formData.append('uuid', uuid);
            formData.append('courseUuid', this.courseUuid);

            this.$inertia.post('/content/delete', formData);
        },

        showModal(content) {
            this.updateEditForm(content);

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
            if (this.saveFiles.length > 0) {
                this.saveFiles.forEach(element =>
                    formData.append('filesSave[]', element)
                );
            }
            if (this.delFiles.length > 0) {
                this.delFiles.forEach(element =>
                    formData.append('filesDel[]', element)
                );
            }
            if (this.addFiles.length > 0) {
                this.addFiles.forEach(element =>
                    formData.append('filesAdd[]', element)
                );
            }
            formData.append('courseUuid', this.courseUuid);

            this.$inertia.post('/content/edit', formData);
        },

        updateFileEdit(event) {
            if (event.target.files[0].type.match("application/pdf")) {
                this.addFiles.push(event.target.files[0]);
            }
        },

        resetFileSave(index) {
            this.delFiles.push(this.saveFiles[index].uuid);
            this.saveFiles.splice(index, 1);
        },

        resetFileAdd(index) {
            this.addFiles.splice(index, 1);
        },

        selectFileEdit() {
            document.getElementById("hidden-input-edit").click();
        },

        updateEditForm(content) {
            this.editForm.uuid = content ? content.uuid : null;
            this.editForm.title = content ? content.title : null;
            this.editForm.description = content ? content.description : null;
            this.editForm.position = content ? content.position : null;
            if (content && content.files.length > 0) {
                content.files.forEach(element =>
                    this.saveFiles.push(element)
                );
            } else {
                this.saveFiles = [];
                this.addFiles = [];
                this.delFiles = [];
            }
        },

        clearFormMessages() {
            this.$page.errors = {};
            this.$page.flash = {};
        }
    }
}
</script>
