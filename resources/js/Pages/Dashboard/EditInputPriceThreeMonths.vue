<template>
    <div>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="edit-price" v-model="data.price_three_months" type="number" min="0" step="0.01" placeholder="0.0">
    </div>
</template>

<script>
export default {
    name: "EditInput",

    props: {
        data: {},

        value: {},
    }
}
</script>
