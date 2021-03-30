<template>
    <div>
        <form @submit.prevent="editSubmit">
            <div class="mb-4 mt-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="edit-title">
                    {{ sectionName }}
                </label>
                <input v-if="$page.errors.titleEdit" class="shadow appearance-none border border-red-700 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="edit-title" type="text" v-model="element.title" :placeholder="sectionName">
                <input v-else class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="edit-title" type="text" v-model="element.title" placeholder="Niveau de formation">
                <p class="text-red-700 mt-2" v-if="$page.errors.titleEdit">{{ $page.errors.titleEdit[0] }}</p>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="edit-description">
                    Description (optionnel)
                </label>
                <textarea v-if="$page.errors.descriptionEdit" class="shadow appearance-none border border-red-700 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="edit-description" v-model="element.description" placeholder="Description (optionnel)"></textarea>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="edit-description" v-model="element.description" placeholder="Description (optionnel)"></textarea>
                <p class="text-red-700 mt-2" v-if="$page.errors.descriptionEdit">{{ $page.errors.descriptionEdit[0] }}</p>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="edit-position">
                    Position
                </label>
                <input v-if="$page.errors.positionEdit" class="shadow appearance-none border border-red-700 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="edit-position" v-model="element.position" type="number" min="0" placeholder="0">
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="edit-position" v-model="element.position" type="number" min="0" placeholder="0">
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
                    <li v-if="!element.image" class="h-full w-full text-center flex flex-col items-center justify-center items-center">
                        <img class="mx-auto w-32" :src="'/img/no-img.png'" alt="Aucune image sélectionnée">
                        <span class="text-sm text-gray-500">Aucune image sélectionnée</span>
                    </li>
                </ul>
                <div class="pt-4" v-if="element.image">
                    <div class="font-semibold text-gray-700 text-sm" v-if="element.image.name">
                        {{ element.image.name }} - <a href="#" v-on:click.prevent="resetFileEdit" class="text-red-700 hover:underline">Supprimer</a>
                    </div>
                    <div class="font-semibold text-gray-700 text-sm" v-else>
                        {{ element.image }} - <a href="#" v-on:click.prevent="resetFileEdit" class="text-red-700 hover:underline">Supprimer</a>
                    </div>
                </div>
                <p class="text-red-700 mt-2" v-if="$page.errors.imageEdit">{{ $page.errors.imageEdit[0] }}</p>
            </div>
            <div class="text-green-700" v-if="$page.flash['successEdit']">
                {{ this.$page.flash['successEdit'] }}
            </div>
            <div class="mt-4 mb-6">
                <span class="flex w-full rounded">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        Enregistrer
                    </button>
                    <button v-on:click="$emit('closeModal')" class="ml-auto bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Fermer
                    </button>
                </span>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    name: "EditElement",

    props: ['element', 'sectionName', 'routeName'],

    methods: {
        editSubmit() {
            axios.post('/' + this.routeName + '/edit', this.forgeFormData()).catch((error) => {
                this.$page.errors = error.response.data.errors
            }).then(response => {
                if (response.data.success) {
                    toastr.success("Modification effectuée.");
                    this.$emit('refreshElements', response.data.elements);
                    this.$emit('clearFormMessages');
                } else
                    toastr.warning("Erreur lors de la modification.");
            });
        },

        forgeFormData() {
            const formData = new FormData();
            if (this.element.uuid)
                formData.append('uuid', this.element.uuid);
            if (this.element.title)
                formData.append('titleEdit', this.element.title);
            if (this.element.description)
                formData.append('descriptionEdit', this.element.description);
            if (this.element.position)
                formData.append('positionEdit', this.element.position);
            if (this.element.image)
                formData.append('imageEdit', this.element.image);
            return formData;
        },

        resetFileEdit() {
            this.element.image = null;
        },

        selectFileEdit() {
            document.getElementById("hidden-input-edit").click();
        },

        updateFileEdit(event) {
            if (event.target.files[0].type.match("image.*"))
                this.element.image = event.target.files[0];
        },
    }
}
</script>
