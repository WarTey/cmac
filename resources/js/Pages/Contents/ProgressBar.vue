<template>
    <div class="bg-gray-200 w-full rounded">
        <div class="bg-green-500 text-white text-center rounded" :style="'width: ' + percentage + '%'">
            {{ percentage }}%
        </div>
    </div>
</template>

<script>
export default {
    name: "ProgressBar",

    props: ['links'],

    computed: {
        percentage() {
            const link = this.links.slice(1, this.links.length - 1).find(link => {
                return link['active']
            });

            return Math.round(link['label'] / (this.links.length - 2) * 100);
        }
    }
}
</script>
