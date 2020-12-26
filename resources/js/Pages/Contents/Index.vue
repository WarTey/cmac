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
                <a :href="'/chapitre/' + chapterUuid" class="hover:underline">
                    {{ chapterTitle | truncate(30) }}
                </a>
                <i class="fas fa-chevron-right fa-xs"></i>
                {{ courseTitle | truncate(30) }}
            </h2>
        </template>
        <!-- TODO : Add Admin verification -->
        <div class="pt-4 max-w-7xl mx-auto sm:px-6 lg:px-8 right-0">
            <div class="flex flex-row-reverse">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" v-on:click="addContent = !addContent">
                    Ajouter un contenu
                </button>
            </div>
        </div>
        <transition name="slide-fade">
            <div class="py-4" v-if="addContent">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="w-full">
                        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" @submit.prevent="submit">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                                    Contenu
                                </label>
                                <input v-if="$page.errors.title" class="shadow appearance-none border border-red-700 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="title" type="text" v-model="form.title" placeholder="Contenu">
                                <input v-else class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="title" type="text" v-model="form.title" placeholder="Contenu">
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
                                    PDF (optionnel)
                                </label>
                                <header class="border-dashed border-2 border-gray-400 py-12 flex flex-col justify-center items-center mb-4">
                                    <input id="hidden-input" type="file" multiple class="hidden" v-on:change="updateFile">
                                    <button id="button" class="mt-2 rounded-sm text-sm px-3 py-1 bg-gray-200 hover:bg-gray-300 focus:shadow-outline focus:outline-none" @click.prevent="selectFile">
                                        Télécharger un PDF
                                    </button>
                                </header>
                                <ul id="gallery" class="flex flex-1 flex-wrap -m-1">
                                    <li id="empty" class="h-full w-full text-center flex flex-col items-center justify-center items-center">
                                        <img class="mx-auto w-32" :src="'/img/no-img.png'" alt="Aucune image sélectionnée">
                                        <span class="text-sm text-gray-500">Aucun PDF sélectionné</span>
                                    </li>
                                </ul>
                                <div class="pt-4" v-for="(file, index) in this.form.files" v-bind:key="file.name">
                                    <div class="font-semibold text-gray-700 text-sm">
                                        {{ file.name }} - <a href="#" v-on:click.prevent="resetFile(index)" class="text-red-700 hover:underline">Supprimer</a>
                                    </div>
                                    <p class="text-red-700 mt-2" v-if="$page.errors.hasOwnProperty('files.' + index)">
                                        Format du fichier ou taille incorrect.
                                    </p>
                                </div>
                            </div>
                            <div class="text-green-700 mb-4" v-if="$page.flash.success">
                                {{ $page.flash.success }}
                            </div>
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                Ajouter le contenu
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </transition>
        <div class="py-4" v-for="content in $page.contents" v-bind:key="content.id">
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
                        <div class="mt-6 text-gray-700 text-justify cursor-pointer hover:underline" v-for="file in content.files" v-bind:key="file.id">
                            {{ file.name }}
                            <canvas class="pdf-files" :id="file.uuid">{{ showFile(file.title, file.uuid) }}</canvas>
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
            form: {
                title: null,
                description: null,
                files: [],
                course_uuid: null
            },
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
            if (this.form.files.length > 0) {
                this.form.files.forEach(element =>
                    formData.append('files[]', element)
                );
            }
            formData.append('course_uuid', this.courseUuid);

            this.$inertia.post('/contents', formData);
        },

        updateFile(event) {
            if (event.target.files[0].type.match("application/pdf")) {
                this.form.files.push(event.target.files[0]);

                if (this.form.files.length > 0) {
                    document.getElementById("empty").classList.add("hidden");
                } else {
                    document.getElementById("empty").classList.remove("hidden");
                }
            }
        },

        resetFile(index) {
            this.form.files.splice(index, 1);

            if (this.form.files.length === 0) {
                document.getElementById("empty").classList.remove("hidden");
            }
        },

        selectFile() {
            document.getElementById("hidden-input").click();
        },

        showFile(url, uuid) {
            pdfjsLib.disableWorker = true;
            pdfjsLib.getDocument("/storage/files/" + url).promise.then(pdf => {
                console.log("NB Pages : " + pdf._pdfInfo.numPages + " pages");
                pdf.getPage(1).then(page => {
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
                });
            });
        }
    }
}
</script>
