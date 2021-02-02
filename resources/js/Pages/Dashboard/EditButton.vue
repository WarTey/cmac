<template>
    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" @click="click(data)" title="Update">
         {{ name }}
    </button>
</template>

<script>
    export default {
        name: "EditButton",

        props: {
            data: {},

            name: {},

            click: {
                type: Function,
                default: () => {}
            },
        }
    }
</script>
