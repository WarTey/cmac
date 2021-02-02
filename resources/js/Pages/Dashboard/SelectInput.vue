<template>
    <select v-model="data.visible" class="border rounded" name="visibilities" id="visibility-select">
        {{ data }}
        <option value="0">Indisponible</option>
        <option value="1">Disponible</option>
    </select>
</template>

<script>
export default {
    name: "SelectInput",

    props: {
        data: {},

        value: {},
    }
}
</script>
