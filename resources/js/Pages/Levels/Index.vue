<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Les formations
            </h2>
        </template>
        <div class="py-4" v-for="level in this.levelList" v-bind:key="level.id">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-lg hover:shadow-xl sm:rounded-lg transition duration-500 ease-in-out">
                    <div v-if="level.image" class="h-20 bg-auto bg-center" :style="'background-image: url(storage/img/levels/' + level.image + ')'"></div>
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <a v-if="level.chapters_count < 1" href="#" v-on:click.prevent="warning('Formation vide.')" class="text-2xl hover:underline">
                                Formation - {{ level.title }}
                            </a>
                            <a v-else :href="'/formation/' + level.uuid" class="text-2xl hover:underline">
                                Formation - {{ level.title }}
                            </a>
                            <div class="text-gray-400">
                                {{ level.chapters_count }} chapitres
                            </div>
                        </div>
                        <div v-if="level.description" class="mt-6 text-gray-500 text-justify">
                            {{ level.description }}
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

        props: ['levels'],

        data() {
            return {
                levelList: this.levels
            }
        },

        methods: {
            warning(message) {
                toastr.warning(message);
            }
        }
    }
</script>
