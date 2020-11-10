<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <div class="flex justify-between items-center">
                    <a :href="'/niveau/' + levelUuid" class="hover:underline">
                        <i class="fas fa-long-arrow-alt-left fa-sm"></i>
                        Niveau - {{ levelTitle }}
                    </a>
                    <div>
                        {{ chapterTitle }}
                    </div>
                </div>
            </h2>
        </template>
        <div class="py-4" v-for="course in this.courseList" v-bind:key="course.id">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-lg hover:shadow-xl sm:rounded-lg transition duration-500 ease-in-out">
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <a v-if="course.contents_count < 1" href="#" v-on:click="notification('Vide')" class="text-2xl hover:underline">
                                {{ course.title }}
                            </a>
                            <a v-else :href="'/cours/' + course.uuid" class="text-2xl hover:underline">
                                {{ course.title }}
                            </a>
                            <div class="text-gray-400">
                                {{ course.contents_count }} cours
                            </div>
                        </div>
                        <div class="mt-6 text-gray-500 text-justify">
                            {{ course.description }}
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

    props: ['courses', 'chapter', 'level'],

    data() {
        return {
            courseList: this.courses,
            chapterTitle: this.chapter.title,
            levelTitle: this.level.title,
            levelUuid: this.level.uuid
        }
    },

    methods: {
        notification(message)
        {
            // TODO : Use library
            alert(message);
        }
    }
}
</script>
