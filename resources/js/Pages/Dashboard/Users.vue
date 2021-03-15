<template>
    <data-table :columns="columns" :data="data" :per-page="perPage" :translate="translate" :framework="framework" @on-table-props-changed="reloadTable"></data-table>
</template>

<script>
import Vue from 'vue';
import DataTable from 'laravel-vue-datatable';
import EditButton from "@/Pages/Dashboard/EditButton";

Vue.use(DataTable);

export default {
    data() {
        return {
            data: {},
            url: "/api/dashboard/users",
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
                    label: '',
                    name: 'Modifier le rang',
                    orderable: false,
                    searchable: false,
                    event: "click",
                    handler: this.setAdmin,
                    component: EditButton
                },
                {
                    label: '',
                    name: 'Supprimer',
                    orderable: false,
                    searchable: false,
                    event: "click",
                    handler: this.delete,
                    component: EditButton
                },
            ],
            tableProps: {
                search: '',
                length: 10,
                column: 'admin',
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
        },

        setAdmin(data) {
            if (this.$page.user.email === data.email) return;

            axios.post("/api/dashboard/user/admin", {
                email: data.email
            }).then(response => {
                if (response.data.success) {
                    toastr.success("Utilisateur modifié.");
                    if (data.admin === "<span class='text-red-700'>Non<span>") {
                        data.admin = "<span class='text-green-700'>Oui<span>";
                    } else {
                        data.admin = "<span class='text-red-700'>Non<span>";
                    }
                } else {
                    toastr.warning("Erreur lors de la modification.");
                }
            });
        },

        delete(data) {
            if (this.$page.user.email === data.email) return;

            if (confirm("Voulez-vous vraiment supprimer cette utilisateur ?")) {
                axios.post("/api/dashboard/user/delete", {
                    email: data.email
                }).then(response => {
                    if (response.data.success) {
                        toastr.success("Utilisateur supprimé.");
                        this.reloadTable(this.tableProps);
                    } else {
                        toastr.warning("Erreur lors de la suppression.");
                    }
                });
            }
        }
    }
}
</script>
