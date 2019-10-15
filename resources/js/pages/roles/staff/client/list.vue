<template>
    <div>
        <div class="filters row">
            <div class="col-sm-2">
                <label for="search_clients">Search</label>
                <input type="text" id="search_clients" class="form-control" @keyup="searchQueryHandler" v-model="search_query">
            </div>
            <div class="col-sm-2">
                <label for="filter_clients">Search</label>
                <select id="filter_clients" class="form-control" @change="loadClients(filters)" v-model="filter_value">
                    <option value="ASC">A - Z</option>
                    <option value="DESC">Z - A</option>
                </select>
            </div>
        </div>
        <template v-if="clients.length > 0">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th>Client</th>
                            <th>Primary Address</th>
                            <th>Primary Contact</th>
                            <th>Telephone</th>
                            <th>Projects Active</th>
                            <th>Projects Completed</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="client in clients">
                            <td class="logo-container">
                                <template v-if="client.logo">
                                    <img class="avatar logo" :src="client.logo" alt="Logo" :title="client.name">
                                </template>
                                <template v-if="!client.logo">
                                    <span class="avatar-placeholder logo" :title="client.name">
                                        <i class="fal fa-user"></i>
                                    </span>
                                </template>
                                <span class="text-truncate">{{client.name}}</span>
                            </td>
                            <td>
                                <span class="text-truncate">{{client.primary_address}}</span>
                            </td>
                            <td>
                                <span class="text-truncate">{{client.primaryContact ? client.primaryContact.full_name: 'N/A'}}</span>
                            </td>
                            <td>
                                <span class="text-truncate">{{client.landline_tele}}</span>
                            </td>
                            <td>
                                <span class="text-truncate">{{client.activeProjects.length}}</span>
                            </td>
                            <td>
                                <span class="text-truncate">{{client.completedProjects.length}}</span>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-primary action-btn" :href="$route('staff.client.edit', client.id)">View</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <pagination :pagesCount="number_of_pages" :currentPageNumber="page_number" @page-changed="pageChangedHandler"></pagination>
        </template>
        <template v-if="!clients.length > 0">
            <p>No clients found</p>
        </template>
    </div>
</template>

<script>
    import Pagination from '../../../../components/mixins/pagination'
    import ClientHelper from '../../../../components/mixins/client-helper'

    export default {
        name: "clients-list",
        mixins: [Pagination, ClientHelper],
        data() {
            return {
                filter_value: 'ASC',
                search_query: ''
            }
        },
        created() {
            this.loadClients();
            this.$eventHub.$on('client-pagination-updated', this.updatePaginationInfo);
        },
        computed: {
            filters() {
                return {
                    order: this.filter_value,
                    search: this.search_query
                }
            }
        },
        methods: {
            pageChangedHandler(page_number) {
                this.page_number = page_number;
                this.loadClients(this.filters);
            },
            searchQueryHandler() {
                if(this.search_query.length > 2 || this.search_query === '') {
                    this.loadClients(this.filters);
                }
            }
        }
    }
</script>
