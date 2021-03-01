<template>
    <app-layout :showingHeader="false" :sidebarItems="null">
        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-lg hover:shadow-xl rounded-lg transition duration-500 ease-in-out">
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        <div class="text-xl text-center">
                            <label for="category-select">Choisissez une catégorie :</label>
                            <select v-model="categorySelected" class="border rounded" name="categories" id="category-select">
                                <option value="history">Historique des connexions</option>
                                <option value="price">Prix des cours</option>
                                <option value="packs">Prix des packs</option>
                            </select>
                        </div>
                        <div class="mt-6">
                            <ConnectionHistory v-if="categorySelected === 'history'"></ConnectionHistory>
                            <CoursesPrice v-if="categorySelected === 'price'"></CoursesPrice>
                            <PacksPrice v-if="categorySelected === 'packs'"></PacksPrice>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout';
    import ConnectionHistory from "@/Pages/Dashboard/ConnectionHistory";
    import CoursesPrice from "@/Pages/Dashboard/CoursesPrice";
    import PacksPrice from "@/Pages/Dashboard/PacksPrice";

    export default {
        components: {
            AppLayout,
            ConnectionHistory,
            CoursesPrice,
            PacksPrice
        },

        data() {
            return {
                categorySelected: "history",
            }
        },

        created() {

        },

        methods: {

        }
    }
</script>
