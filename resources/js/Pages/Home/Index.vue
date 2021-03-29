<template>
    <app-layout :showingHeader="false">
        <div class="py-4">
            <header class="pt-10 pb-24" id="wheel-header">
                <div id="menu" class="py-5 text-center">
                    <ul>
                        <li id="products" class="slice">
                            <a href="#" class="rounded-full pt-1 text-xs md:text-sm lg:text-base">
                                <span class="icn">
                                    <i class="icn fas fa-book-open fa-lg"></i>
                                </span>
                                <span class="no-icn hidden">
                                    <span class="text-model hidden">Produits & Services</span>
                                </span>
                            </a>
                        </li>
                        <li id="resources" class="slice">
                            <a href="#" class="rounded-full pt-1 text-xs md:text-sm lg:text-base">
                                <span class="icn">
                                    <i class="icn fas fa-briefcase fa-lg"></i>
                                </span>
                                <span class="no-icn hidden">
                                    <span class="text-model hidden">Cours & Exercices</span>
                                </span>
                            </a>
                        </li>
                        <li id="forum" class="slice">
                            <a href="#" class="rounded-full pt-1 text-xs md:text-sm lg:text-base">
                                <span class="icn">
                                    <i class="icn fas fa-comments fa-lg"></i>
                                </span>
                                <span class="no-icn hidden">
                                    <span class="text-model hidden">Livre d'or & Forum</span>
                                </span>
                            </a>
                        </li>
                        <li id="art-science" class="slice">
                            <a href="#" class="rounded-full pt-1 text-xs md:text-sm lg:text-base">
                                <span class="icn">
                                    <i class="icn fas fa-atom fa-lg"></i>
                                </span>
                                <span class="no-icn hidden">
                                    <span class="text-model hidden">Articles scientifiques</span>
                                </span>
                            </a>
                        </li>
                        <li id="old-students" class="slice">
                            <a href="#" class="rounded-full pt-1 text-xs md:text-sm lg:text-base">
                                <span class="icn">
                                    <i class="icn fas fa-address-book fa-lg"></i>
                                </span>
                                <span class="no-icn hidden">
                                    <span class="text-model hidden">Annuaire des Anciens</span>
                                </span>
                            </a>
                        </li>
                        <li id="middle" class="rounded-full"></li>
                    </ul>
                    <div id="arrow" class="mb-auto">
                        <i class="fas fa-sync-alt fa-lg"></i>
                    </div>
                </div>
            </header>
            <div class="max-w-2xl xl:max-w-7xl mx-auto sm:px-6 lg:px-8 grid sm:grid-cols-2 xl:grid-cols-4 gap-12 xl:gap-4 pb-10 justify-center">
                <div class="bg-white overflow-hidden shadow-lg hover:shadow-xl rounded-lg h-96 max-w-xs">
                    <img src="https://picsum.photos/400/600" alt="Card image" class="w-full h-full">
                </div>
                <div class="bg-white overflow-hidden shadow-lg hover:shadow-xl rounded-lg h-96 overflow-y-auto max-w-xs">
                    <img src="https://picsum.photos/100/50" alt="Card image" class="w-full h-24">
                    <div class="mx-4">
                        <p class="mt-4 text-xl">Article scientifique</p>
                        <p class="mt-2 mb-2 text-sm text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus a imperdiet velit, quis pharetra neque. Vestibulum gravida id eros ut ornare. Pellentesque vel lacus sed nunc scelerisque posuere. Integer consectetur odio dignissim nibh congue ultrices. Donec id magna ante. Donec auctor turpis eu ante dapibus euismod. Vivamus suscipit ex eget hendrerit sagittis. Aenean lacus tellus, posuere nec aliquam eu, aliquam et enim.</p>
                        <a class="text-sm pb-4 hover:underline" href="#">Voir la suite...</a>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-lg hover:shadow-xl rounded-lg h-96 overflow-y-auto max-w-xs">
                    <div id="result-iframe-youtube" class="w-full"></div>
                    <div class="mx-4">
                        <p class="mt-4 text-xl" id="result-title-youtube"></p>
                        <p class="mt-2 mb-2 text-sm text-justify" id="result-text-youtube"></p>
                        <a class="text-sm pb-4 hover:underline" id="result-url-youtube" href="#">Voir la suite...</a>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-lg hover:shadow-xl rounded-lg h-96 max-w-xs">
                    <div class="fb-page w-full h-full" data-href="https://www.facebook.com/CoursMathsAC" data-tabs="timeline,events,messages" data-width="500" data-height="475" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                        <blockquote cite="https://www.facebook.com/CoursMathsAC" class="fb-xfbml-parse-ignore">
                            <a href="https://www.facebook.com/CoursMathsAC">Cours de Mathématiques Anthony Cordier</a>
                        </blockquote>
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

    props: [],

    data() {
        return {

        }
    },

    watch: {

    },

    created: function() {
        axios.get("https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=1&playlistId=UUP4eZIghdl2Pneq5vH4XiRA&forUsername=coursmaths_ac&key=AIzaSyDnHrh5DobcXSGN5FhZj6O1JUh7lZt4zOM").then(response => {
            response.data.items.forEach(item => {
                document.getElementById('result-iframe-youtube').innerHTML += '<iframe class="w-full" src="https://www.youtube.com/embed/' + item.snippet.resourceId.videoId + '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                document.getElementById('result-title-youtube').innerHTML += item.snippet.title;
                document.getElementById('result-text-youtube').innerHTML += item.snippet.description.replace(/(\r\n|\n|\r)/gm, "<br/>").substring(0, 500) + " ...";
                document.getElementById('result-url-youtube').setAttribute("href", "https://youtu.be/qbpaa7qzhjo" + item.snippet.resourceId.videoId);
            })
        });
    },

    methods: {

    }
}
</script>
