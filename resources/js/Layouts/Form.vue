<template>
    <form class="bg-white shadow-md rounded px-6 md:max-w-xl w-full" :class="[hasMaxHeight ? 'max-h-4/5 overflow-auto' : 'py-6']">
        <slot></slot>
    </form>
</template>

<script>
    export default {
        name: "Form",

        props: ['hasMaxHeight']
    }
</script>
