<template>
    <div>
        <div class="filters row">
            <div class="col-sm-2">
                <label for="search_projects">Search</label>
                <input type="text" id="search_projects" class="form-control" @keyup="searchQueryHandler" v-model="filters.search">
            </div>
            <div class="col-sm-2">
                <label for="filter_events">Filter By</label>
                <select id="filter_events" class="form-control" @change="loadProjects(filters)" v-model="filters.event">
                    <option value="" disabled>All Events</option>
                    <option v-for="event in events" :value="event.id">{{event.name}}</option>
                </select>
            </div>
            <div class="col-sm-2">
                <label for="filter_statuses" class="hidden-xs">Filter By</label>
                <select id="filter_statuses" class="form-control" @change="loadProjects(filters)" v-model="filters.status">
                    <option value="" disabled>All Statuses</option>
                    <option v-for="status in statuses" :value="status.id">{{status.name}}</option>
                </select>
            </div>
            <div class="col-sm-2">
                <label for="sort_by" class="hidden-xs">Sort By</label>
                <select id="sort_by" class="form-control" @change="loadProjects(filters)" v-model="filters.order">
                    <option value="event_soonest">Soonest</option>
                    <option value="project_last_updated">Last Updated</option>
                </select>
            </div>
        </div>
        <div class="filters flex-row d-flex">
            <div class="flex-column mr-4">
                <div class="avatar-placeholder all-users avatar-square flex-column cursor-pointer avatar-selector" @click="selectUserFilter(false)">
                    <i class=" fal fa-users"></i>
                    <span>All</span>
                </div>
                <span :class="'filter-selection-bar' + (!selected_user ? ' selected' : '')"></span>
            </div>

            <div v-for="staff_member in staff" class="flex-column mr-4">
                <img v-if="staff_member.avatar" class="avatar avatar-square cursor-pointer avatar-selector" :src="staff_member.avatar" :alt="staff_member.full_name" :title="staff_member.full_name" @click="selected_user = staff_member">
                <i v-if="!staff_member.avatar" class="avatar-placeholder avatar-square fal fa-user avatar-selector cursor-pointer" :title="staff_member.full_name" @click="selectUserFilter(staff_member)"></i>
                <span :class="'filter-selection-bar' + (selected_user.id ===  staff_member.id ? ' selected' : '')"></span>
            </div>
        </div>
        <template v-if="projects.length > 0">
            <h2 v-if="selected_user">{{selected_user.full_name}}</h2>
            <h2 v-else>All Users</h2>
            <div class="row">
                <div v-for="project in projects" class="col-md-6 col-md-4 col-lg-3">
                    <project-summary :project="project"></project-summary>
                </div>
            </div>
            <pagination v-if="number_of_pages > 1" :pagesCount="number_of_pages" :currentPageNumber="page_number" @page-changed="pageChangedHandler"></pagination>
        </template>
        <template v-if="!projects.length > 0">
            <div class="col-sm-12">
                <p>No projects found</p>
            </div>
        </template>
    </div>
</template>

<script>
    import ProjectHelper from '../../../../components/mixins/project-helper'
    import EventHelper from '../../../../components/mixins/event-helper'
    import UserHelper from '../../../../components/mixins/user-helper'
    import Pagination from '../../../../components/mixins/pagination'

    export default {
        name: "list",
        mixins: [ProjectHelper, EventHelper, UserHelper, Pagination],
        mounted() {
            this.loadEvents({all:true});
            this.loadProjectStatuses();
            this.loadStaff();
            this.loadProjects();
        },
        data() {
          return {
              selected_user: false
          }
        },
        computed: {
          filters() {
              return {
                  page: this.page_number,
                  search: '',
                  status: '',
                  event: '',
                  order: 'event_soonest',
                  user: this.selected_user.id
              }
            }
        },
        methods: {
            selectUserFilter(staff_member) {
                this.selected_user = staff_member;
                this.loadProjects(this.filters);
            },
            pageChangedHandler(page_number) {
                this.page_number = page_number;
                this.loadProjects(this.filters);
            },
            searchQueryHandler() {
                if(this.filters.search.length > 2 || this.filters.search.length === '') {
                    this.loadProjects(this.filters);
                }
            }
        }
    }
</script>
