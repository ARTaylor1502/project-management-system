<template>
    <li id="add_project_details_step" class="list-group-item">
        <h2>Project Details</h2>
        <div class="row">
            <div class="col-md-6">
                <label class="col-form-label" for="user_id">Project Owner</label>
                <dropdown
                        :label="'Select a Project Owner...'"
                        :options="users"
                        :id="'user_id'"
                        :labelSeparator="' '"
                        value-key="id"
                        label-key="first_name"
                        label-key2="last_name"
                        @input-selected="userHandler">
                </dropdown>
            </div>
            <div class="col-md-6">
                <label class="col-form-label" for="status_id">Status*</label>
                <dropdown
                        :label="'Select a Project Status...'"
                        :options="project_statuses"
                        :id="'status_id'"
                        value-key="id"
                        label-key="name"
                        @input-selected="statusHandler">
                </dropdown>
            </div>
        </div>
    </li>
</template>

<script>
    import dropdown from '../../../../../../../components/drop-down'

    export default {
        name: "details-step",
        components: {
            dropdown
        },
        data() {
            return {
                user: {},
                status: {},
                users: [],
                project_statuses: []
            }
        },
        mounted(){
            this.loadUsers();
            this.loadProjectStatuses();
        },
        methods: {
            infoChanged() {
                if(this.user.id && this.status.id) {
                    this.$emit('details-step-complete',{
                        project_owner: this.user,
                        status: this.status
                    });
                } else {
                    this.$emit('details-step-incomplete');
                }
            },
            loadUsers() {
                this.users = [];

                axios.get('/api/user?all=true')
                .then(response => {
                    response.data.forEach((user) => {
                        this.users.push(user);
                    });

                    if(this.users.length > 0) {
                        this.user = this.users[0].id;
                    }

                }).catch(function (error) {
                    console.log(error);
                });
            },
            loadProjectStatuses() {
                this.project_statuses = [];

                axios.get('/api/project/statuses')
                .then(response => {
                    response.data.forEach((status) => {
                        this.project_statuses.push(status);
                    });
                }).catch(function (error) {
                    console.log(error);
                });
            },
            userHandler(e) {
                this.user = e;
                this.infoChanged();
            },
            statusHandler(e) {
                this.status = e;
                this.infoChanged();
            }
        }
    }
</script>
