<template>
    <data-table :columns="columns" :data="data" :per-page="perPage" :translate="translate" :framework="framework" @on-table-props-changed="reloadTable"></data-table>
</template>

<script>
    import Vue from 'vue';
    import DataTable from 'laravel-vue-datatable';

    Vue.use(DataTable);

    export default {
        data() {
            return {
                data: {},
                url: "/api/dashboard/logs",
                framework: "tailwind",
                translate: {
                    nextButton: 'Suivant',
                    previousButton: 'Précédent',
                    placeholderSearch: 'Recherche'
                },
                columns: [
                    {
                        label: 'Nom',
                        name: 'name',
                        orderable: true,
                        searchable: true
                    },
                    {
                        label: 'Mail',
                        name: 'email',
                        orderable: true,
                        searchable: true
                    },
                    {
                        label: 'Admin',
                        name: 'admin',
                        orderable: true,
                        searchable: true
                    },
                    {
                        label: 'IP',
                        name: 'ip_address',
                        orderable: true,
                        searchable: true
                    },
                    {
                        label: 'Date',
                        name: 'login_at',
                        orderable: true,
                        searchable: true
                    },
                ],
                tableProps: {
                    search: '',
                    length: 10,
                    column: 'authentication_log.login_at',
                    dir: 'desc'
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
                    this.data.data.forEach(element => {
                        if (element.admin === 1) {
                            element.admin = "<span class='text-green-700'>Oui<span>";
                        } else {
                            element.admin = "<span class='text-red-700'>Non<span>";
                        }
                        element.login_at = new Date(element.login_at).toLocaleString("fr-FR");
                    });
                });
            },

            reloadTable(tableProps) {
                if (tableProps.column === "id") {
                    tableProps.column = this.tableProps.column;
                }
                this.getData(this.url, tableProps);
            }
        }
    }
</script>
