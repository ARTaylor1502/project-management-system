export default {
    data () {
        return {
            user: false,
            users: [],
            titles: [],
            roles: [],
            events: [],
            projects: [],
            staff: [],
            projects_count: 0
        }
    },
    methods: {
        loadUser(user_id) {
            let self = this;

            axios.get(this.$route('api.user.single', user_id))
            .then(response => {
                self.user = response.data;
            }).catch(function (error) {
                console.log(error);
            });
        },
        loadUsers(filters) {
            let self = this, url = '/api/user';

            if(filters !== undefined) {
                let count = 0;

                for (var key in filters) {
                    if (filters.hasOwnProperty(key)) {
                        if(count === 0) {
                            url += '?';
                        } else {
                            url += '&';
                        }

                        url += key + '=' + filters[key];
                        count++;
                    }
                }
            }

            axios.get(url)
            .then(response => {
                self.resetUsers();

                response.data.data.forEach(function(client) {
                    self.users.push(client);
                });

                self.$eventHub.$emit('user-pagination-updated', {number_of_pages: response.data.last_page, page_number: response.data.current_page, total_items_count: response.data.total});
            }).catch(function (error) {
                console.log(error);
            });
        },
        loadStaff() {
            let self = this;

            axios.get(this.$route('api.user.staff'))
            .then(response => {
                response.data.forEach(function(staff_member) {
                    self.staff.push(staff_member);
                });
            }).catch(function (error) {
                console.log(error);
            });
        },
        addUser(user_data) {
            let self = this;

            axios.post(this.$route('api.user.store'), user_data, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                if(response.data.status === 'success') {
                    this.$eventHub.$emit('new-user-added', response.data.user.id);
                } else if(response.data.status === 'error') {
                    this.$eventHub.$emit('new-user-added-error', response.data.errors);
                }
            }).catch(function (error) {
                console.log(error);
            });
        },
        loadRoles() {
            let self = this;

            axios.get(this.$route('api.user.roles'))
                .then(response => {
                    self.roles = [];

                    response.data.forEach(function(role) {
                        self.roles.push(role);
                    });
                }).catch(function (error) {
                console.log(error);
            });
        },
        loadTitles() {
            let self = this;

            axios.get(this.$route('api.user.titles'))
                .then(response => {
                    response.data.forEach(function(title) {
                        self.titles.push(title);
                    });
                }).catch(function (error) {
                console.log(error);
            });
        },
        updateUser(user_id, fields) {
            let self = this;

            axios.post(this.$route('api.user.update', user_id), fields)
            .then(response => {
                if(response.data.status === 'success') {
                    self.$eventHub.$emit('user-updated');
                } else if(response.data.status === 'error') {
                    self.$eventHub.$emit('user-update-errors', response.data.errors);
                }

            }).catch(function (error) {
                console.log(error);
            });
        },
        loadAllUserEvents(user_id) {
            let self = this;

            axios.get(this.$route('api.user.events', user_id))
            .then(response => {
                response.data.forEach(function(event) {
                    self.events.push(event);
                });
            }).catch(function (error) {
                console.log(error);
            });
        },
        loadUserProjectsCount(user_id) {
            let self = this;

            axios.get('/api/project/user/' + user_id + '?count=true')
            .then(response => {
                self.projects_count = response.data;
            }).catch(function (error) {
                console.log(error);
            });
        },
        loadUserProjects(user_id, filters) {
            let self = this, url = '/api/project/user/' + user_id;

            if(filters !== undefined) {
                let count = 0;

                for (var key in filters) {
                    if (filters.hasOwnProperty(key)) {
                        if(count === 0) {
                            url += '?';
                        } else {
                            url += '&';
                        }

                        url += key + '=' + filters[key];
                        count++;
                    }
                }
            }

            axios.get(url)
            .then(response => {
                self.resetUserProjects();

                response.data.data.forEach(function(project) {
                    self.projects.push(project);
                });

                self.$eventHub.$emit('user-project-pagination-updated', {number_of_pages: response.data.last_page, page_number: response.data.current_page, total_items_count: response.data.total});
            }).catch(function (error) {
                console.log(error);
            });
        },
        resetUserProjects() {
            this.projects = [];
        },
        resetUsers() {
            this.users = [];
        },
    }
}
