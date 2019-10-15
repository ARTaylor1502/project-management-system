<template>
    <div>
        <template v-if="projects.length > 0">
            <div class="row">
                <div v-for="project in projects" class="col-md-6 col-md-4 col-lg-3">
                    <a :href="$route('client.project.edit', project.id)">
                        <div class="card project">
                            <div class="card-header">
                                <img v-if="project.client.logo" class="avatar" :src="project.client.logo" alt="Logo" :title="project.client.name">
                                <span v-else class="avatar-placeholder" :title="project.client.name">
                                    <i class="fal fa-user"></i>
                                </span>
                            </div>
                            <div class="card-body">
                                <h2 class="text-truncate">{{project.name}}</h2>
                                <h3 class="text-truncate">{{project.client.name}}</h3>
                                <h3>#{{project.id}}</h3>
                            </div>
                            <div class="status-container">
                                <div class="status-inner-container">
                                    <span :class="'status project-' + project.status.name.toLowerCase()">{{project.status.name}}</span>
                                    <div :class="'users-container' + (project.users.length > 3 ? ' has-additional-users' : '')">
                                        <template v-for="user,index in project.users">
                                            <template v-if="index < 3">
                                                <img v-if="user.avatar" class="avatar user-logo-container" :src="user.avatar" alt="Avatar" :title="user.full_name">
                                                <span v-else class="avatar-placeholder user-logo-container" :title="user.full_name">
                                                    <i class="fal fa-user"></i>
                                                </span>
                                            </template>
                                        </template>
                                    </div>
                                    <span v-if="project.users && project.users.length > 3" class="avatar-placeholder user-logo-container remaining-users-amount">+{{project.users.length - 3}}</span>
                                </div>
                            </div>
                            <div class="card-footer">
                                <h4 class="text-truncate"><i class="fal fa-alarm-clock"></i> Last updated {{project.last_updated_formatted}}</h4>
                                <h4 class="text-truncate"><i class="fal fa-calendar-alt"></i> {{project.event.name}} {{project.event.start_date_formatted}} {{project.event.start_time_formatted}}</h4>
                            </div>
                        </div>
                    </a>
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
    export default {
        name: "client-projects-list",
        props: ['client_id'],
        data() {
            return {
                projects: [],
                number_of_pages: 0,
                page_number: 1,
            }
        },
        mounted() {
            this.loadProjects();
        },
        methods: {
            loadProjects() {
                let self = this;

                axios.get('/api/client/'+this.client_id+'/projects?page=' + self.page_number)
                .then(response => {
                    self.resetProjects();

                    response.data.forEach(function(project) {
                        self.projects.push(project);
                    });
                    self.number_of_pages = response.data.last_page;
                    self.page_number = response.data.current_page;
                }).catch(function (error) {
                    console.log(error);
                });
            },
            resetProjects() {
                this.projects = [];
            },
            pageChangedHandler(page_number) {
                this.page_number = page_number;
                this.loadProjects();
            }
        }
    }
</script>
