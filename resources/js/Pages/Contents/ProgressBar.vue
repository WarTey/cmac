<template>
    <div class="w-full text-center">
        {{ contentName }}
        <div class="flex items-center h-4 pt-2">
            <div v-for="(content, index) in contents" v-bind:key="content.uuid" v-bind:class="{'mr-1': index < contents.length - 1, 'bg-green-400': content.users_count > 0, 'h-4': contentIndex === index}" class="bg-gray-400 text-white text-center w-full cursor-pointer h-3 transition-all duration-300" v-on:mouseover="contentName = content.title" v-on:mouseleave="contentName = name" v-on:click="$emit('updateContentIndex', index)"></div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ProgressBar",

    props: ['name', 'contents', 'contentIndex'],

    data() {
        return {
            contentName: this.name
        }
    },

    computed: {
        percentage() {
            const completed = this.contents.filter(content => {
                return content.users_count > 0
            });

            return Math.round(completed.length / this.contents.length * 100);
        }
    }
}
</script>
