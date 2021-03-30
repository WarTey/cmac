<template>
    <app-layout :showingHeader="true" :sidebarItems="sidebarItems">
        <template #header>
            <h2 class="font-semibold text-gray-800 leading-tight">
                Les formations
            </h2>
        </template>
        <div v-if="$page.user && $page.user.admin" class="pt-4 max-w-7xl mx-auto sm:px-6 lg:px-8 right-0">
            <div class="flex flex-row-reverse">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" v-on:click="toggleAddLevel">
                    Ajouter une formation
                </button>
            </div>
        </div>
        <transition name="slide-fade">
            <div class="py-4" v-if="$page.user && $page.user.admin && addLevel">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="w-full">
                        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                            <add-element :element="createForm" section-name="Niveau de formation" route-name="formation" @refreshElements="refreshElements" @clearFormMessages="clearFormMessages" />
                        </div>
                    </div>
                </div>
            </div>
        </transition>
        <show-elements :elements="$page.levels" child-name="chapitres" img-url="levels" link-url="formation" route-name="formation" @showModal="showModal" @refreshElements="refreshElements" />
        <div v-if="$page.user && $page.user.admin && modalVisible" class="fixed overflow-hidden top-0 left-0 flex items-center justify-center w-full h-full bg-black bg-opacity-50">
            <div class="bg-white shadow-md rounded px-8 md:max-w-xl w-full max-h-4/5 overflow-auto">
                <edit-element :element="editForm" section-name="Niveau de formation" route-name="formation" @closeModal="closeModal" @refreshElements="refreshElements" @clearFormMessages="clearFormMessages" />
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from "@/Layouts/AppLayout";
    import Input from "@/Jetstream/Input";
    import ShowElements from "@/Layouts/ShowElements";
    import EditElement from "@/Layouts/EditElement";
    import AddElement from "@/Layouts/AddElement";

    export default {
        components: {
            ShowElements,
            EditElement,
            AddElement,
            Input,
            AppLayout
        },

        props: ['levels', 'sidebarItems'],

        data() {
            return {
                addLevel: false,
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
                    position: null,
                    image: null
                }
            }
        },

        methods: {
            toggleAddLevel() {
                this.addLevel = !this.addLevel;

                this.clearFormMessages();
            },

            refreshElements(elements) {
                this.$page.levels = elements;
            },

            showModal(level) {
                this.updateEditForm(level);

                this.modalVisible = true;
            },

            closeModal() {
                this.modalVisible = false;

                this.updateEditForm(null);
                this.clearFormMessages();
            },

            updateEditForm(level) {
                this.editForm.uuid = level ? level.uuid : null;
                this.editForm.title = level ? level.title : null;
                this.editForm.description = level ? level.description : null;
                this.editForm.position = level ? level.position : null;
                this.editForm.image = level ? level.image : null;
            },

            clearFormMessages() {
                this.$page.errors = {};
                this.$page.flash = {};
            }
        }
    }
</script>
