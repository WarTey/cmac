<template>
    <div>
        <div class="flex flex-row-reverse pb-4">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" v-on:click="showModal(null)">
                Ajouter un pack
            </button>
        </div>
        <data-table :columns="columns" :data="data" :per-page="perPage" :translate="translate" :framework="framework" @on-table-props-changed="reloadTable"></data-table>
        <div v-if="$page.user && $page.user.admin && (modalVisible || modalCourses)" class="fixed overflow-hidden top-0 left-0 flex items-center justify-center w-full h-full bg-black bg-opacity-50">
            <div v-if="modalCourses" class="bg-white shadow-md rounded py-4 px-8 md:max-w-xl w-full max-h-4/5 overflow-auto">
                <div class="mb-2 text-2xl">
                    Cours dans le pack {{ selectedPack.title }}
                </div>
                <p v-if="selectedPack.courses.length > 0" v-for="course in selectedPack.courses" v-bind:key="course.uuid">
                    <a target="_blank" rel="noopener noreferrer" :href="'/cours/' + course.uuid" class="hover:underline">{{ course.title }}</a>
                </p>
                <p v-else>
                    <span>Aucun cours dans ce pack pour le moment...</span>
                </p>
                <div class="mt-4 mb-4">
                    <select multiple class="form-select mt-1 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" v-model="selectedPack.courses">
                        <option :value="course" v-for="course in courses" v-bind:key="course.uuid">{{ course.title }}</option>
                    </select>
                </div>
                <div class="mt-8">
                    <span class="flex w-full rounded">
                        <button v-on:click="closeModal" class="ml-auto bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Fermer
                        </button>
                    </span>
                </div>
            </div>
            <form v-if="modalVisible" class="bg-white shadow-md rounded px-8 md:max-w-xl w-full max-h-4/5 overflow-auto" @submit.prevent="submit">
                <div class="mb-4 mt-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                        Pack
                    </label>
                    <input v-if="$page.errors.title" class="shadow appearance-none border border-red-700 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="title" type="text" v-model="form.title" placeholder="Pack">
                    <input v-else class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="title" type="text" v-model="form.title" placeholder="Pack">
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
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="position">
                        Position
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="position" v-model="form.position" type="number" min="0" placeholder="0">
                    <p class="text-red-700 mt-2" v-if="$page.errors.position">{{ $page.errors.position[0] }}</p>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="courses">
                        <span class="text-gray-700">Cours</span>
                        <select multiple id="courses" class="form-select mt-1 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" v-model="form.courses">
                            <option :value="course.uuid" v-for="course in courses" v-bind:key="course.uuid">{{ course.title }}</option>
                        </select>
                    </label>
                    <p class="text-red-700 mt-2" v-if="$page.errors.courses">{{ $page.errors.courses[0] }}</p>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="price">
                        Prix (1 mois)
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="price" v-model="form.price" type="number" min="0" step="0.01" placeholder="0.0">
                    <p class="text-red-700 mt-2" v-if="$page.errors.price">{{ $page.errors.price[0] }}</p>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="price-three">
                        Prix (3 mois)
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="price-three" v-model="form.priceThree" type="number" min="0" step="0.01" placeholder="0.0">
                    <p class="text-red-700 mt-2" v-if="$page.errors.priceThree">{{ $page.errors.priceThree[0] }}</p>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="price-six">
                        Prix (6 mois)
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="price-six" v-model="form.priceSix" type="number" min="0" step="0.01" placeholder="0.0">
                    <p class="text-red-700 mt-2" v-if="$page.errors.priceSix">{{ $page.errors.priceSix[0] }}</p>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="chapter">
                        <span class="text-gray-700">Chapitre d'appartenance</span>
                        <select id="chapter" class="form-select mt-1 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" v-model="form.chapter">
                            <option :value="chapter.uuid" v-for="chapter in chapters" v-bind:key="chapter.uuid">{{ chapter.title }}</option>
                        </select>
                    </label>
                    <p class="text-red-700 mt-2" v-if="$page.errors.chapter">{{ $page.errors.chapter[0] }}</p>
                </div>
                <div class="mb-2 flex flex-col">
                    <label>
                        <input type="radio" class="form-radio" name="visibility" value="0" v-model="form.visibility">
                        <span class="ml-2">Cours indisponible</span>
                    </label>
                    <label>
                        <input type="radio" class="form-radio" name="visibility" value="1" v-model="form.visibility">
                        <span class="ml-2">Cours disponible</span>
                    </label>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Image (optionnel)
                    </label>
                    <header class="border-dashed border-2 border-gray-400 py-12 flex flex-col justify-center items-center mb-4">
                        <input id="hidden-input-edit" type="file" class="hidden" v-on:change="updateFile">
                        <button id="button-edit" class="mt-2 rounded-sm text-sm px-3 py-1 bg-gray-200 hover:bg-gray-300 focus:shadow-outline focus:outline-none" @click.prevent="selectFile">
                            Télécharger une image
                        </button>
                    </header>
                    <ul id="gallery" class="flex flex-1 flex-wrap -m-1">
                        <li v-if="!this.packImage" class="h-full w-full text-center flex flex-col items-center justify-center items-center">
                            <img class="mx-auto w-32" :src="'/img/no-img.png'" alt="Aucune image sélectionnée">
                            <span class="text-sm text-gray-500">Aucune image sélectionnée</span>
                        </li>
                    </ul>
                    <div class="pt-4" v-if="this.packImage">
                        <div class="font-semibold text-gray-700 text-sm" v-if="this.packImage.name">
                            {{ this.packImage.name }} - <a href="#" v-on:click.prevent="resetFile" class="text-red-700 hover:underline">Supprimer</a>
                        </div>
                        <div class="font-semibold text-gray-700 text-sm" v-else>
                            {{ this.packImage }} - <a href="#" v-on:click.prevent="resetFile" class="text-red-700 hover:underline">Supprimer</a>
                        </div>
                    </div>
                    <p class="text-red-700 mt-2" v-if="$page.errors.image">{{ $page.errors.image[0] }}</p>
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
    </div>
</template>

<script>
import Vue from 'vue';
import DataTable from 'laravel-vue-datatable';
import EditButton from "@/Pages/Dashboard/EditButton";
import SelectInput from "@/Pages/Dashboard/SelectInput";
import EditInputPrice from "@/Pages/Dashboard/EditInputPrice";
import EditInputPriceThreeMonths from "@/Pages/Dashboard/EditInputPriceThreeMonths";
import EditInputPriceSixMonths from "@/Pages/Dashboard/EditInputPriceSixMonths";

Vue.use(DataTable);

export default {
    data() {
        return {
            data: {},
            url: "/api/dashboard/packsTable",
            framework: "tailwind",
            translate: {
                nextButton: 'Suivant',
                previousButton: 'Précédent',
                placeholderSearch: 'Recherche'
            },
            columns: [
                {
                    label: 'Titre',
                    name: 'title',
                    orderable: true,
                    searchable: true
                },
                {
                    label: 'Visible',
                    name: 'visible',
                    orderable: true,
                    searchable: true,
                    component: SelectInput
                },
                {
                    label: 'Prix (1 mois)',
                    name: 'price',
                    orderable: true,
                    searchable: true,
                    component: EditInputPrice
                },
                {
                    label: 'Prix (3 mois)',
                    name: 'price_three_months',
                    orderable: true,
                    searchable: true,
                    component: EditInputPriceThreeMonths
                },
                {
                    label: 'Prix (6 mois)',
                    name: 'price_six_months',
                    orderable: true,
                    searchable: true,
                    component: EditInputPriceSixMonths
                },
                {
                    label: '',
                    name: 'Cours',
                    orderable: false,
                    searchable: false,
                    event: "click",
                    handler: this.showCourses,
                    component: EditButton
                },
                {
                    label: '',
                    name: 'Modifier',
                    orderable: false,
                    searchable: false,
                    event: "click",
                    handler: this.updateData,
                    component: EditButton
                },
            ],
            tableProps: {
                search: '',
                length: 10,
                column: 'title',
                dir: 'asc'
            },
            perPage: ['10', '25', '50'],
            modalVisible: false,
            modalCourses: false,
            selectedPack: null,
            form: {
                title: null,
                description: null,
                position: null,
                price: null,
                priceThree: null,
                priceSix: null,
                visibility: null,
                image: null,
                chapter: null,
                courses: []
            },
            packImage: null,
            chapters: null,
            courses: null
        }
    },

    created() {
        this.getData(this.url);
        this.getChapters();
        this.getCourses();
    },

    methods: {
        getData(url = this.url, options = this.tableProps) {
            axios.get(url, {
                params: options
            }).then(response => {
                this.data = response.data;
                console.log(this.data);
            });
        },

        getChapters() {
            axios.get("/api/dashboard/chapters").then(response => {
                this.chapters = response.data;
            });
        },

        getCourses() {
            axios.get("/api/dashboard/courses").then(response => {
                this.courses = response.data;
            });
        },

        reloadTable(tableProps) {
            if (tableProps.column === "id") {
                tableProps.column = this.tableProps.column;
            }
            this.getData(this.url, tableProps);
        },

        updateData(data) {
            axios.post("/api/dashboard/pack/edit", {
                uuid: data.uuid,
                price: data.price,
                price_three_months: data.price_three_months,
                price_six_months: data.price_six_months,
                courses: data.courses,
                visibility: data.visible === "1" || data.visible === 1,
            }).then(response => {
                if (response.data.success) {
                    toastr.success("Pack mis à jour.");
                } else {
                    toastr.warning("Erreur lors de la mise à jour.");
                }
            });
        },

        showModal(pack) {
            this.updateForm(pack);

            this.modalVisible = true;
        },

        closeModal() {
            this.modalVisible = false;
            this.modalCourses = false;
            this.selectedPack = null;

            this.updateForm(null);
            this.clearFormMessages();
        },

        clearFormMessages() {
            this.$page.errors = {};
            this.$page.flash = {};
        },

        updateForm(form) {
            this.form.uuid = form ? form.uuid : null;
            this.form.title = form ? form.title : null;
            this.form.description = form ? form.description : null;
            this.form.position = form ? form.position : null;
            this.form.price = form ? form.price : null;
            this.form.priceThree = form ? form.price_three_months : null;
            this.form.priceSix = form ? form.price_six_months : null;
            this.form.visibility = form ? form.visible : null;
            this.form.chapter = form ? form.chapter : null;
            this.form.courses = form ? form.courses : [];
            this.packImage = form ? form.image : null;
        },

        updateFile(event) {
            if (event.target.files[0].type.match("image.*")) {
                this.packImage = event.target.files[0];
            }
        },

        resetFile() {
            this.packImage = null;
        },

        selectFile() {
            document.getElementById("hidden-input-edit").click();
        },

        submit() {
            axios.post('/api/dashboard/pack/store', {
                uuid: this.form.uuid,
                title: this.form.title,
                description: this.form.description,
                position: this.form.position,
                price: this.form.price,
                priceThree: this.form.priceThree,
                priceSix: this.form.priceSix,
                visibility: this.form.visibility,
                chapter: this.form.chapter,
                courses: this.form.courses,
                image: this.packImage
            }).then(response => {
                console.log(response);
                if (response.data.success) {
                    this.getData(this.url);
                    this.closeModal();
                    toastr.success("Pack ajouté.");
                } else {
                    this.$page.errors = response.data.errors;
                }
            });
        },

        showCourses(data) {
            this.modalCourses = !this.modalCourses;
            this.selectedPack = this.modalCourses ? data : null;
        },
    }
}
</script>
