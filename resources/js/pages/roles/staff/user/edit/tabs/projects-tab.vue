<template>
    <div>
        <div class="filters row">
            <div class="col-sm-2">
                <label for="search_projects">Search</label>
                <input type="text" id="search_projects" class="form-control" @keyup="searchQueryHandler" v-model="search_query">
            </div>
            <div class="col-sm-2">
                <label for="filter_events">Filter By</label>
                <select id="filter_events" class="form-control" @change="loadUserProjects(user_id, filters)" v-model="filter_events_value">
                    <option value="" disabled>All Events</option>
                    <option v-for="event in events" :value="event.id">{{event.name}}</option>
                </select>
            </div>
            <div class="col-sm-2">
                <label for="filter_statuses" class="hidden-xs">Filter By</label>
                <select id="filter_statuses" class="form-control" @change="loadUserProjects(user_id, filters)" v-model="filter_status_value">
                    <option value="" disabled>All Statuses</option>
                    <option v-for="status in statuses" :value="status.id">{{status.name}}</option>
                </select>
            </div>
        </div>
        <template v-if="projects.length > 0">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Project Name</th>
                                <th>Project Type</th>
                                <th>Event</th>
                                <th>Client</th>
                                <th>Active Tasks</th>
                                <th>Completed Tasks</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="project in projects">
                                <td>{{project.status.name}}</td>
                                <td>{{project.name}}</td>
                                <td>{{project.project_type.name}}</td>
                                <td>{{project.event.name}}</td>
                                <td>{{project.client.name}}</td>
                                <td>{{activeTasks(project.tasks).length}}</td>
                                <td>{{completedTasks(project.tasks).length}}</td>
                                <td>
                                    <a class="btn btn-sm btn-primary action-btn" :href="$route('staff.project.edit', project.id)">View</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <pagination :pagesCount="number_of_pages" :currentPageNumber="page_number" @page-changed="pageChangedHandler"></pagination>
        </template>
        <template v-if="!projects.length > 0">
            <p>No projects found</p>
        </template>
    </div>
</template>

<script>
    import UserHelper from '../../../../../../components/mixins/user-helper'
    import ProjectHelper from '../../../../../../components/mixins/project-helper'
    import TaskHelper from '../../../../../../components/mixins/task-helper'
    import Pagination from '../../../../../../components/mixins/pagination'

    export default {
        name: "projects-tab",
        props: ['user_id'],
        mixins: [UserHelper, ProjectHelper, TaskHelper, Pagination],
        data() {
            return {
                filter_events_value: '',
                filter_status_value: '',
                search_query: ''
            }
        },
        mounted() {
            this.loadAllUserEvents(this.user_id);
            this.loadProjectStatuses(this.user_id);
            this.loadUserProjects(this.user_id);
        },
        created() {
            this.$eventHub.$on('user-project-pagination-updated', this.updatePaginationInfo);
        },
        computed: {
          filters() {
              return {
                  page: this.page_number,
                  event: this.filter_events_value,
                  status: this.filter_status_value,
                  search: this.search_query
              }
          }
        },
        methods: {
            pageChangedHandler(page_number) {
                this.page_number = page_number;
                this.loadUserProjects(this.user_id, this.filters);
            },
            searchQueryHandler() {
                if(this.search_query.length > 2 || this.search_query === '') {
                    this.loadUserProjects(this.user_id, this.filters);
                }
            }
        }
    }
</script>
