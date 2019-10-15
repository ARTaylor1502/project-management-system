export default {
    data () {
        return {
            project: false,
            statuses: [],
            projects: [],
            project_types: [],
            task_categories: []
        }
    },
    methods: {
        loadProjects(filters) {
            let self = this, url = '/api/project';

            if(filters !== undefined) {
                let count = 0;

                for (var key in filters) {
                    if (filters.hasOwnProperty(key)) {
                        if(filters[key]) {
                            if(count === 0) {
                                url += '?';
                            } else {
                                url += '&';
                            }
                            url += key + '=' + filters[key];
                        }

                        count++;
                    }
                }
            }

            axios.get(url)
            .then(response => {
                self.resetProjects();

                response.data.data.forEach(function(project) {
                    self.projects.push(project);
                });

                self.$eventHub.$emit('project-pagination-updated', {number_of_pages: response.data.last_page, page_number: response.data.current_page, total_items_count: response.data.total});
            }).catch(function (error) {
                console.log(error);
            });
        },
        addProject(project_data) {
            let self = this;

            axios.post(this.$route('api.project.store'), project_data, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                if(response.data.status === 'success') {
                    self.$eventHub.$emit('new-project-added', response.data.project.id);
                } else if(response.data.status === 'error') {
                    self.$eventHub.$emit('new-project-added-errors', response.data.errors);
                }
            }).catch(function (error) {
                if(error.response) {
                    console.log(error.response.data.errors);
                }
            });
        },
        loadProject(project_id) {
            let self = this;

            axios.get(this.$route('api.project.single', project_id))
                .then(response => {
                    self.project = response.data;
                }).catch(function (error) {
                console.log(error);
            });
        },
        loadProjectStatuses() {
            let self = this;

            axios.get(this.$route('api.project.statuses'))
            .then(response => {
                response.data.forEach(function(status) {
                    self.statuses.push(status);
                });
            }).catch(function (error) {
                console.log(error);
            });
        },
        loadProjectDepartmentTaskCategories(project_id) {
            let self = this;

            axios.get(this.$route('api.task.project.department.task.categories', project_id))
            .then(response => {
                self.task_categories = [];

                response.data.forEach(function(status) {
                    self.task_categories.push(status);
                });
            }).catch(function (error) {
                console.log(error);
            });
        },
        loadProjectTypes() {
            let self = this;

            axios.get(this.$route('api.project.types'))
            .then(response => {
                response.data.forEach((project_type) => {
                    self.project_types.push(project_type);
                });
            }).catch(function (error) {
                console.log(error);
            });
        },
        resetProjects() {
            this.projects = [];
        }
    }
}
