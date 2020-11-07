<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Les niveaux de formation
            </h2>
        </template>
        <div class="py-4" v-for="level in this.levelList" v-bind:key="level.id">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-lg hover:shadow-xl sm:rounded-lg transition duration-500 ease-in-out">
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <a href="#" class="text-2xl hover:underline">
                                {{ level.title }}
                            </a>
                            <div class="text-gray-400">
                                X chapitres
                            </div>
                        </div>
                        <div class="mt-6 text-gray-500 text-justify">
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

        data() {
            return {
                levelList: this.levels
            }
        },

        props: ['levels'],

        mounted() {
            console.log(this.levels);
        }
    }
</script>
