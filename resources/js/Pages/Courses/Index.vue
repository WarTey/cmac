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
                {{ chapterTitle | truncate(30) }}
            </h2>
        </template>
        <LoginForm :showLogin="loginForm" @updateLoginForm="updateLoginForm"></LoginForm>
        <div v-if="$page.user && $page.user.admin" class="pt-4 max-w-7xl mx-auto sm:px-6 lg:px-8 right-0">
            <div class="flex flex-row-reverse">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" v-on:click="toggleAddCourse">
                    Ajouter un cours
                </button>
            </div>
        </div>
        <transition name="slide-fade">
            <div class="py-4" v-if="$page.user && $page.user.admin && addCourse">
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
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="price">
                                    Prix (1 mois)
                                </label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="price" v-model="createForm.price" type="number" min="0" step="0.01" placeholder="0.0">
                                <p class="text-red-700 mt-2" v-if="$page.errors.priceStore">{{ $page.errors.priceStore[0] }}</p>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="price-three">
                                    Prix (3 mois)
                                </label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="price-three" v-model="createForm.priceThree" type="number" min="0" step="0.01" placeholder="0.0">
                                <p class="text-red-700 mt-2" v-if="$page.errors.priceThreeStore">{{ $page.errors.priceThreeStore[0] }}</p>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="price-six">
                                    Prix (6 mois)
                                </label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="price-six" v-model="createForm.priceSix" type="number" min="0" step="0.01" placeholder="0.0">
                                <p class="text-red-700 mt-2" v-if="$page.errors.priceSixStore">{{ $page.errors.priceSixStore[0] }}</p>
                            </div>
                            <div class="mb-2 flex flex-col">
                                <label>
                                    <input type="radio" class="form-radio" name="visibility" value="0" v-model="createForm.visibility">
                                    <span class="ml-2">Cours indisponible</span>
                                </label>
                                <label>
                                    <input type="radio" class="form-radio" name="visibility" value="1" v-model="createForm.visibility">
                                    <span class="ml-2">Cours disponible</span>
                                </label>
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
                <div class="bg-white overflow-hidden shadow-lg hover:shadow-xl rounded-lg transition duration-500 ease-in-out">
                    <div v-if="course.image" class="h-20 bg-auto bg-center" :style="'background-image: url(/storage/img/courses/' + course.image + ')'"></div>
                    <div v-bind:class="{ 'bg-gray-300': course.price > 0 && (($page.user && $page.user.admin === 0) || $page.user == null) && course.users.length === 0 }" class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <a v-if="course.contents_count >= 0 && $page.user && $page.user.admin" :href="'/cours/' + course.uuid" class="text-2xl hover:underline">
                                {{ course.title }}
                            </a>
                            <a v-else-if="course.contents_count > 0 && ((course.users.length > 0 && course.price > 0) || course.price === 0) " :href="'/cours/' + course.uuid" class="text-2xl hover:underline">
                                {{ course.title }}
                            </a>
                            <div v-else class="text-2xl">
                                {{ course.title }}
                            </div>
                            <div class="text-gray-400">
                                {{ course.contents_count }} cours
                            </div>
                        </div>
                        <div class="mt-6 text-gray-500 text-justify">
                            {{ course.description }}
                        </div>
                        <div v-if="course.price > 0 && (($page.user && $page.user.admin === 0) || $page.user == null) && course.users.length === 0" class="mt-6 flex justify-center text-xl">
                            <button v-on:click="showStrip(course)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Acheter à partir de {{ course.price }}€
                            </button>
                        </div>
                        <div v-if="$page.user && $page.user.admin" class="mt-4 flex">
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
        <div v-if="stripeVisible" class="fixed overflow-hidden top-0 left-0 flex items-center justify-center w-full h-full bg-black bg-opacity-50">
            <form class="bg-white shadow-md rounded px-8 md:max-w-xl w-full max-h-4/5 overflow-auto" action="#">
                <div class="mb-4 mt-6 text-2xl">
                    {{ clientCourse.title }}
                </div>
                <div class="mb-4">
                    <span>Choisissez une formule :</span>
                    <div class="flex flex-col mt-2">
                        <label class="border rounded p-4 mb-2">
                            <input checked type="radio" class="form-radio" name="formulae" value="1" v-model="stripeDuration">
                            <span class="ml-2">1 mois pour <span class="text-green-700 text-lg">{{ clientCourse.price }}€</span></span>
                        </label>
                        <label class="border rounded p-4 mb-2">
                            <input type="radio" class="form-radio" name="formulae" value="3" v-model="stripeDuration">
                            <span class="ml-2">3 mois pour <span class="text-red-700 text-lg line-through">{{ 3 * clientCourse.price }}€</span> <span class="text-green-700 text-lg">{{ clientCourse.price_three_months }}€</span></span>
                        </label>
                        <label class="border rounded p-4">
                            <input type="radio" class="form-radio" name="formulae" value="6" v-model="stripeDuration">
                            <span class="ml-2">6 mois pour <span class="text-red-700 text-lg line-through">{{ 6 * clientCourse.price }}€</span> <span class="text-green-700 text-lg">{{ clientCourse.price_six_months }}€</span></span>
                        </label>
                    </div>
                </div>
                <div class="mt-6 pb-4">
                    <div id="card-element"></div>
                    <div id="card-errors" role="alert" class="text-red-700 mt-2"></div>
                    <div class="text-sm float-right">
                        Powered by <span class="font-bold underline">Stripe</span>
                        <i class="fas fa-lock"></i>
                    </div>
                </div>
                <div class="mt-8 mb-6">
                    <span class="flex w-full rounded">
                        <button v-on:click.prevent="stripeCheckout" id="submitStripe" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Acheter
                        </button>
                        <button v-on:click="closeStrip" class="ml-auto bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Fermer
                        </button>
                    </span>
                </div>
            </form>
        </div>
        <div v-if="$page.user && $page.user.admin && modalVisible" class="fixed overflow-hidden top-0 left-0 flex items-center justify-center w-full h-full bg-black bg-opacity-50">
            <form class="bg-white shadow-md rounded px-8 md:max-w-xl w-full max-h-4/5 overflow-auto" @submit.prevent="editSubmit">
                <div class="mb-4 mt-6">
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
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="edit-position">
                        Position
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="edit-position" v-model="editForm.position" type="number" min="0" placeholder="0">
                    <p class="text-red-700 mt-2" v-if="$page.errors.positionEdit">{{ $page.errors.positionEdit[0] }}</p>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="edit-price">
                        Prix (1 mois)
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="edit-price" v-model="editForm.price" type="number" min="0" step="0.01" placeholder="0.0">
                    <p class="text-red-700 mt-2" v-if="$page.errors.priceEdit">{{ $page.errors.priceEdit[0] }}</p>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="edit-price-three">
                        Prix (3 mois)
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="edit-price-three" v-model="editForm.priceThree" type="number" min="0" step="0.01" placeholder="0.0">
                    <p class="text-red-700 mt-2" v-if="$page.errors.priceThreeEdit">{{ $page.errors.priceThreeEdit[0] }}</p>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="edit-price-six">
                        Prix (6 mois)
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="edit-price-six" v-model="editForm.priceSix" type="number" min="0" step="0.01" placeholder="0.0">
                    <p class="text-red-700 mt-2" v-if="$page.errors.priceSixEdit">{{ $page.errors.priceSixEdit[0] }}</p>
                </div>
                <div class="mb-2 flex flex-col">
                    <label>
                        <input type="radio" class="form-radio" name="visibility" value="0" v-model="editForm.visibility">
                        <span class="ml-2">Cours indisponible</span>
                    </label>
                    <label>
                        <input type="radio" class="form-radio" name="visibility" value="1" v-model="editForm.visibility">
                        <span class="ml-2">Cours disponible</span>
                    </label>
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
                <div class="mt-4 mb-6">
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
import LoginForm from "@/Layouts/LoginForm";

export default {
    components: {
        AppLayout,
        LoginForm
    },

    props: ['courses', 'chapter', 'level', 'sidebarItems'],

    data() {
        return {
            chapterTitle: this.chapter.title,
            chapterUuid: this.chapter.uuid,
            levelTitle: this.level.title,
            levelUuid: this.level.uuid,
            addCourse: false,
            modalVisible: false,
            stripeVisible: false,
            loginForm: false,
            createForm: {
                title: null,
                description: null,
                position: null,
                price: null,
                priceThree: null,
                priceSix: null,
                visibility: null,
                image: null
            },
            editForm: {
                uuid: null,
                title: null,
                description: null,
                position: null,
                price: null,
                priceThree: null,
                priceSix: null,
                visibility: null,
            },
            editImage: null,
            stripe: null,
            stripeElements: null,
            stripeStyle: null,
            stripeCard: null,
            stripeDuration: 1,
            clientSecret: null,
            clientCourse: null
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

    mounted() {
        this.stripe = Stripe('pk_test_51IGCNgLnof75IVchPBdJxLGv8C0kvKPTJmur2oWthhVpaIkUfyc9A5H8AWLtnokFvcu00nea7oZBoJynmhBpwP7g00gHltRcTH');
        this.stripeElements = this.stripe.elements();
        this.stripeStyle = {
            base: {
                color: "#32325d",
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: "antialised",
                fontSize: "16px",
                "::placeholder": {
                    color: "#aab7c4"
                }
            },
            invalid: {
                color: "#fa755a",
                iconColor: "#fa755a"
            }
        }
        this.stripeCard = this.stripeElements.create("card", { style: this.stripeStyle });
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
            if (this.createForm.price) {
                formData.append('priceStore', this.createForm.price);
            }
            if (this.createForm.priceThree) {
                formData.append('priceThreeStore', this.createForm.priceThree);
            }
            if (this.createForm.priceSix) {
                formData.append('priceSixStore', this.createForm.priceSix);
            }
            if (this.createForm.visibility) {
                formData.append('visibilityStore', this.createForm.visibility);
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
            if (this.editForm.price) {
                formData.append('priceEdit', this.editForm.price);
            }
            if (this.editForm.priceThree) {
                formData.append('priceThreeEdit', this.editForm.priceThree);
            }
            if (this.editForm.priceSix) {
                formData.append('priceSixEdit', this.editForm.priceSix);
            }
            if (this.editForm.visibility) {
                formData.append('visibilityEdit', this.editForm.visibility);
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
            this.editForm.price = course ? course.price : null;
            this.editForm.priceThree = course ? course.price_three_months : null;
            this.editForm.priceSix = course ? course.price_six_months : null;
            this.editForm.visibility = course ? course.visible : null;
            this.editImage = course ? course.image : null;
        },

        clearFormMessages() {
            this.$page.errors = {};
            this.$page.flash = {};
        },

        showStrip(course) {
            if (this.$page.user == null) {
                this.updateLoginForm(true);
            } else if (course.users.length === 0 && course.price > 0) {
                this.stripeDuration = 1;
                axios.post("/stripe", {
                    uuid: course.uuid,
                    price: course.price * 100
                }).then(response => {
                    if (response.data.success) {
                        this.clientCourse = course;
                        this.stripeVisible = !this.stripeVisible;
                        this.clientSecret = response.data.secret;
                        setTimeout(() => this.initStrip(), 250);
                    } else {
                        toastr.warning("Erreur lors de l'ouverture du menu d'achat");
                    }
                });
            }
        },

        initStrip() {
            this.stripeCard.mount("#card-element");
            this.stripeCard.addEventListener('change', ({error}) => {
                const displayError = document.getElementById('card-errors');
                if (error) {
                    displayError.textContent = error.message;
                } else {
                    displayError.textContent = '';
                }
            });
        },

        unlockCourse(uuid) {
            this.closeStrip();
            axios.post("/stripe/buy", {
                uuid: uuid,
                chapterUuid: this.chapterUuid,
                duration: this.stripeDuration
            }).then(response => {
                if (response.data.success) {
                    this.$page.courses = response.data.courses;
                } else {
                    toastr.warning("Erreur lors de l'ajout du cours. Veuillez prendre contact avec CMAC.");
                }
            });
        },

        stripeCheckout() {
            // TODO : Check not in possession of profile
            if (this.clientSecret != null) {
                toastr.success("Veuillez patienter...");
                this.stripe.confirmCardPayment(this.clientSecret, {
                    payment_method: {
                        card: this.stripeCard
                    }
                }).then(result => {
                    if (result.error) {
                        toastr.warning(result.error.message);
                    } else {
                        if (result.paymentIntent.status === 'succeeded') {
                            toastr.success("Vous possédez maintenant le cours");
                            this.unlockCourse(result.paymentIntent.description);
                        }
                    }
                });
            }
        },

        closeStrip() {
            this.stripeVisible = !this.stripeVisible;
            this.clientSecret = null;
            this.clientCourse = null;
        },

        updateLoginForm(value) {
            this.loginForm = value;
        }
    }
}
</script>
