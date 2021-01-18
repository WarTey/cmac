<template>
    <app-layout :showingHeader="false" :sidebarItems="null">
        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-lg hover:shadow-xl rounded-lg transition duration-500 ease-in-out">
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        test
                        <!--<data-table :columns="columns" :url="url"></data-table>-->
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import Vue from 'vue';
    import AppLayout from '@/Layouts/AppLayout';
    //import DataTable from 'laravel-vue-datatable';

    //Vue.use(DataTable);

    export default {
        components: {
            AppLayout,
        },

        data() {
            return {
                /*url: "/api/dashboard/logs",
                perPage: ['10', '25', '50'],
                tableProps: {
                    search: '',
                    length: 10,
                    column: 'created_at',
                    dir: 'asc'
                },
                columns: [
                    {
                        label: 'Nom',
                        name: 'user.name',
                        orderable: true,
                        searchable: true
                    },
                    {
                        label: 'Mail',
                        name: 'user.email',
                        orderable: true,
                        searchable: true
                    },
                    {
                        label: 'Description',
                        name: 'description',
                        orderable: true,
                        searchable: true
                    },
                    {
                        label: 'Date',
                        name: 'created_at',
                        orderable: true,
                        searchable: true
                    },
                ],*/
            }
        },

        /*created() {
            this.getData(this.url);
        },

        methods: {
            getData(url = this.url, options = this.tableProps) {
                axios.get(url, {
                    params: options
                }).then(response => {
                    console.log(response);
                    this.data = response.data;
                }).catch(errors => {
                    console.log(errors);
                });
            },

            reloadTable(tableProps) {
                this.getData(this.url, tableProps);
            }
        }*/
    }
</script>
