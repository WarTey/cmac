<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-gray-800 leading-tight">
                <a :href="route('levels.index')" class="hover:underline">
                    Les formations
                </a>
                <i class="fas fa-chevron-right fa-xs"></i>
                {{ levelTitle | truncate(30) }}
            </h2>
        </template>
        <div class="py-4" v-for="chapter in this.chapterList" v-bind:key="chapter.uuid">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-lg hover:shadow-xl sm:rounded-lg transition duration-500 ease-in-out">
                    <div v-if="chapter.image" class="h-20 bg-auto bg-center" :style="'background-image: url(storage/img/levels/' + level.image + ')'"></div>
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <a v-if="chapter.courses_count < 1" href="#" v-on:click="warning('Vide')" class="text-2xl hover:underline">
                                {{ chapter.title }}
                            </a>
                            <a v-else :href="'/chapitre/' + chapter.uuid" class="text-2xl hover:underline">
                                {{ chapter.title }}
                            </a>
                            <div class="text-gray-400">
                                {{ chapter.courses_count }} sous-chapitres
                            </div>
                        </div>
                        <div class="mt-6 text-gray-500 text-justify">
                            {{ chapter.description }}
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

    props: ['chapters', 'level'],

    data() {
        return {
            chapterList: this.chapters,
            levelTitle: this.level.title
        }
    },

    methods: {
        warning(message) {
            toastr.warning(message);
        }
    }
}
</script>
