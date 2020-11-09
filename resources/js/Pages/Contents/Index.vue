<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <div class="flex justify-between items-center">
                    <a :href="'/chapitre/' + chapterId" class="hover:underline">
                        <i class="fas fa-long-arrow-alt-left fa-sm"></i>
                        {{ chapterTitle }}
                    </a>
                    <div>
                        {{ courseTitle }}
                    </div>
                </div>
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
                        <div class="mt-6 text-gray-500 text-justify cursor-pointer hover:underline" v-for="file in content.files" v-bind:key="file.id">
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

    props: ['contents', 'course', 'chapter'],

    data() {
        return {
            contentList: this.contents,
            courseTitle: this.course.title,
            chapterTitle: this.chapter.title,
            chapterId: this.chapter.id
        }
    }
}
</script>
