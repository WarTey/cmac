<template>
    <div>
        <div class="py-4" v-for="element in elements" v-bind:key="element.uuid">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-lg hover:shadow-xl rounded-lg transition duration-500 ease-in-out">
                    <div v-if="element.image" class="h-20 bg-auto bg-center" :style="'background-image: url(/storage/img/' + imgUrl + '/' + element.image + ')'"></div>
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <a v-if="element['child_count'] >= 0 && $page.user && $page.user.admin" :href="'/' + linkUrl + '/' + element.uuid" class="text-2xl hover:underline">
                                {{ element.title }}
                            </a>
                            <a v-else-if="element['child_count'] > 0" :href="'/' + linkUrl + '/' + element.uuid" class="text-2xl hover:underline">
                                {{ element.title }}
                            </a>
                            <a v-else class="text-2xl">
                                {{ element.title }}
                            </a>
                            <div class="text-gray-400">
                                {{ element['child_count'] }} {{ childName }}
                            </div>
                        </div>
                        <div v-if="element.description" class="mt-6 text-gray-500 text-justify">
                            {{ element.description }}
                        </div>
                        <div class="mt-4 flex" v-if="$page.user && $page.user.admin">
                            <a class="text-blue-500 font-semibold text-justify hover:underline cursor-pointer" v-on:click="$emit('showModal', element)">
                                Éditer
                            </a>
                            <a class="text-red-500 font-semibold text-justify hover:underline cursor-pointer ml-auto" v-on:click="remove(element)">
                                Retirer
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ShowElements",

    props: ['elements', 'childName', 'imgUrl', 'linkUrl', 'routeName'],

    methods: {
        remove(uuid) {
            axios.post('/' + this.routeName + '/delete', {
                uuid: uuid,
            }).then(response => {
                if (response.data.success) {
                    toastr.success("Suppression effectuée.");
                    this.$emit('refreshElements', response.data.elements);
                } else
                    toastr.warning("Erreur lors de la suppression.");
            });
        },
    }
}
</script>
