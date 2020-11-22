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
        <div class="py-4" v-for="content in this.contentList" v-bind:key="content.id">
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
                            <!-- TODO : Update database with file.name and file.location -->
                            {{ file.name }}
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
            contentList: this.contents,
            courseTitle: this.course.title,
            chapterTitle: this.chapter.title,
            chapterUuid: this.chapter.uuid,
            levelTitle: this.level.title,
            levelUuid: this.level.uuid
        }
    }
}
</script>
