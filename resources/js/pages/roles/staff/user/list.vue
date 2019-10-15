<template>
    <div>
        <div class="filters row">
            <div class="col-sm-2">
                <label for="search_users">Search:</label>
                <input type="text" id="search_users" class="form-control" @keyup="searchQueryHandler" v-model="search_query" placeholder="Find a user">
            </div>
            <div class="col-sm-2">
                <label for="filter_users">Filter By:</label>
                <select id="filter_users" class="form-control" @change="loadUsers(filters)" v-model="filter_value">
                    <option value="staff">Staff</option>
                    <option value="client">Client</option>
                    <option value="contractor">Contractor</option>
                    <option value="supplier">Supplier</option>
                </select>
            </div>
            <div class="col-sm-2">
                <label for="sort_users">Sort By:</label>
                <select id="sort_users" class="form-control" @change="loadUsers(filters)" v-model="sort_value">
                    <option value="last-name_asc">A - Z</option>
                    <option value="last-name_desc">Z - A</option>
                    <option value="last-login_asc">Last Login</option>
                    <option value="created-at_desc">Date Added</option>
                </select>
            </div>
        </div>
        <template v-if="users.length > 0">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Last Login</th>
                                <th>Date Added</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr v-for="user in users">
                            <td>
                                <span class="text-truncate">{{user.full_name}}</span>
                            </td>
                            <td>
                                <span class="text-truncate">{{user.role.name}}</span>
                            </td>
                            <td>
                                <span class="text-truncate">{{user.last_login_formatted ? user.last_login_formatted : 'N/A'}}</span>
                            </td>
                            <td>
                                <span class="text-truncate">{{user.created_at_formatted ? user.created_at_formatted : 'N/A'}}</span>
                            </td>
                            <td>
                                <span class="text-truncate">{{user.email}}</span>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-primary action-btn" :href="$route('staff.user.edit', user.id)">View</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <pagination v-if="number_of_pages > 1" :pagesCount="number_of_pages" :currentPageNumber="page_number" @page-changed="pageChangedHandler"></pagination>
        </template>
        <template v-if="!users.length > 0">
            <p>No users found</p>
        </template>
    </div>
</template>

<script>
    import UserHelper from '../../../../components/mixins/user-helper'
    import Pagination from '../../../../components/mixins/pagination'

    export default {
        name: "list",
        mixins: [UserHelper, Pagination],
        data() {
            return {
                filter_value: 'staff',
                sort_value: 'last-name_asc',
                search_query: ''
            }
        },
        created() {
            this.loadUsers(this.filters);
            this.$eventHub.$on('user-pagination-updated', this.updatePaginationInfo);
        },
        computed: {
          filters() {
              return {
                  page: this.page_number,
                  filter: this.filter_value,
                  order: this.sort_value,
                  search: this.search_query
              }
            }
        },
        methods: {
            resetUsers() {
                this.users = [];
            },
            pageChangedHandler(page_number) {
                this.page_number = page_number;
                this.loadUsers(this.filters);
            },
            searchQueryHandler() {
                if(this.search_query.length > 2 || this.search_query === '') {
                    this.loadUsers(this.filters);
                }
            }
        }
    }
</script>

<style scoped>

</style>
