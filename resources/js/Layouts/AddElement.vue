<template>
    <div>
        <form @submit.prevent="storeSubmit">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                    {{ sectionName }}
                </label>
                <input v-if="$page.errors.titleStore" class="shadow appearance-none border border-red-700 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="title" type="text" v-model="element.title" :placeholder="sectionName">
                <input v-else class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="title" type="text" v-model="element.title" placeholder="Niveau de formation">
                <p class="text-red-700 mt-2" v-if="$page.errors.titleStore">{{ $page.errors.titleStore[0] }}</p>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                    Description (optionnel)
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" v-model="element.description" placeholder="Description (optionnel)"></textarea>
                <p class="text-red-700 mt-2" v-if="$page.errors.descriptionStore">{{ $page.errors.descriptionStore[0] }}</p>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="position">
                    Position
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="position" v-model="element.position" type="number" min="0" placeholder="0">
                <p class="text-red-700 mt-2" v-if="$page.errors.positionStore">{{ $page.errors.positionStore[0] }}</p>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">
                    Image (optionnel)
                </label>
                <header class="border-dashed border-2 border-gray-400 py-12 flex flex-col justify-center items-center mb-4">
                    <input id="hidden-input-store" type="file" class="hidden" v-on:change="updateFileStore">
                    <button id="button-store" class="mt-2 rounded-sm text-sm px-3 py-1 bg-gray-200 hover:bg-gray-300 focus:shadow-outline focus:outline-none" @click.prevent="selectFileStore">
                        Télécharger une image
                    </button>
                </header>
                <ul id="gallery-store" class="flex flex-1 flex-wrap -m-1">
                    <li v-if="!this.element.image" class="h-full w-full text-center flex flex-col items-center justify-center items-center">
                        <img class="mx-auto w-32" :src="'/img/no-img.png'" alt="Aucune image sélectionnée">
                        <span class="text-sm text-gray-500">Aucune image sélectionnée</span>
                    </li>
                </ul>
                <div class="pt-4" v-if="this.element.image">
                    <div class="font-semibold text-gray-700 text-sm">
                        {{ this.element.image.name }} - <a href="#" v-on:click.prevent="resetFileStore" class="text-red-700 hover:underline">Supprimer</a>
                    </div>
                </div>
                <p class="text-red-700 mt-2" v-if="$page.errors.imageStore">{{ $page.errors.imageStore[0] }}</p>
            </div>
            <div class="text-green-700 mb-4" v-if="$page.flash.successStore">
                {{ $page.flash.successStore }}
            </div>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Ajouter
            </button>
        </form>
    </div>
</template>

<script>
export default {
    name: "AddElement",

    props: ['element', 'sectionName', 'routeName'],

    methods: {
        storeSubmit() {
            axios.post('/' + this.routeName + '/store', this.forgeFormData()).catch((error) => {
                this.$page.errors = error.response.data.errors;
            }).then(response => {
                if (response.data.success) {
                    toastr.success("Création effectuée.");
                    this.$emit('refreshElements', response.data.elements);
                    this.$emit('clearFormMessages');
                } else
                    toastr.warning("Erreur lors de la création.");
            });
        },

        forgeFormData() {
            const formData = new FormData();
            if (this.element.title)
                formData.append('titleStore', this.element.title);
            if (this.element.description)
                formData.append('descriptionStore', this.element.description);
            if (this.element.position)
                formData.append('positionStore', this.element.position);
            if (this.element.image)
                formData.append('imageStore', this.element.image);
            return formData;
        },

        updateFileStore(event) {
            if (event.target.files[0].type.match("image.*"))
                this.element.image = event.target.files[0];
        },

        resetFileStore() {
            this.element.image = null;
        },

        selectFileStore() {
            document.getElementById("hidden-input-store").click();
        },
    }
}
</script>
