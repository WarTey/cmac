<template>
    <app-layout :showingHeader="false" :sidebarItems="null">
        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-lg hover:shadow-xl rounded-lg transition duration-500 ease-in-out">
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        <div class="text-2xl text-center">
                            Historique des connexions
                        </div>
                        <div class="mt-6">
                            <data-table :columns="columns" :data="data" :per-page="perPage" :translate="translate" :framework="framework" @on-table-props-changed="reloadTable"></data-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import Vue from 'vue';
    import AppLayout from '@/Layouts/AppLayout';
    import DataTable from 'laravel-vue-datatable';

    Vue.use(DataTable);

    export default {
        components: {
            AppLayout,
        },

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
            }
        }
    }
</script>
