<template>
    <data-table :columns="columns" :data="data" :per-page="perPage" :translate="translate" :framework="framework" @on-table-props-changed="reloadTable"></data-table>
</template>

<script>
import Vue from 'vue';
import DataTable from 'laravel-vue-datatable';
import EditButton from "@/Pages/Dashboard/EditButton";
import SelectInput from "@/Pages/Dashboard/SelectInput";
import EditInput from "@/Pages/Dashboard/EditInput";

Vue.use(DataTable);

export default {
    data() {
        return {
            data: {},
            url: "/api/dashboard/courses",
            framework: "tailwind",
            translate: {
                nextButton: 'Suivant',
                previousButton: 'Précédent',
                placeholderSearch: 'Recherche'
            },
            columns: [
                {
                    label: 'Titre',
                    name: 'title',
                    orderable: true,
                    searchable: true
                },
                {
                    label: 'Visible',
                    name: 'visible',
                    orderable: true,
                    searchable: true,
                    component: SelectInput
                },
                {
                    label: 'Prix',
                    name: 'price',
                    orderable: true,
                    searchable: true,
                    component: EditInput
                },
                {
                    label: '',
                    name: 'Modifier',
                    orderable: false,
                    searchable: false,
                    event: "click",
                    handler: this.updateData,
                    component: EditButton
                },
            ],
            tableProps: {
                search: '',
                length: 10,
                column: 'title',
                dir: 'asc'
            },
            perPage: ['10', '25', '50'],
        }
    },

    created() {
        this.getData(this.url);
    },

    methods: {
        getData(url = this.url, options = this.tableProps) {
            axios.get(url, {
                params: options
            }).then(response => {
                this.data = response.data;
            });
        },

        reloadTable(tableProps) {
            if (tableProps.column === "id") {
                tableProps.column = this.tableProps.column;
            }
            this.getData(this.url, tableProps);
        },

        updateData(data) {
            axios.post("/api/dashboard/courses/edit", {
                uuid: data.uuid,
                price: data.price,
                visibility: data.visible === "1" || data.visible === 1,
            }).then(response => {
                if (response.data.success) {
                    toastr.success("Cours mis à jour.");
                } else {
                    toastr.warning("Erreur lors de la mise à jour.");
                }
            });
        },
    }
}
</script>
