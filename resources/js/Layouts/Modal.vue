<template>
    <div class="fixed overflow-hidden top-0 left-0 flex items-center justify-center w-full h-full bg-black bg-opacity-50">
        <slot></slot>
    </div>
</template>

<script>
    export default {
        name: "Modal"
    }
</script>
