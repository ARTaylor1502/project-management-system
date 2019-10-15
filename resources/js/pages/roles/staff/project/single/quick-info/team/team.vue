<template>
    <div class="col-md-12 col-lg-4">
        <h2>Team</h2>
        <div class="card h-100">
            <div class="card-body h-50 flex-vertical-align">
                <div class="row w-100">
                    <div class="col-sm-5 flex-vertical-align">
                        <label>Project Owner</label>
                    </div>
                    <div class="col-sm-7">
                        <select class="form-control" v-model="projectOwner" @change="updateProjectOwner">
                            <option v-for="user in users" :value="user.id">{{user.full_name}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer h-50 flex-vertical-align">
                <div class="row w-100">
                    <div class="col-md-6 flex-vertical-align justify-content-end">
                        <div class="users-container" :class="'children-' + project.users.length">
                           <template v-for="(user,index) in project.users">
                                <template v-if="index < 3">
                                    <img v-if="user.avatar" class="avatar user-logo-container" :src="user.avatar" alt="Avatar" :title="user.full_name">
                                    <span v-else class="avatar-placeholder user-logo-container" :title="user.full_name">
                                        <i class="fal fa-user"></i>
                                    </span>
                                </template>
                            </template>
                        </div>
                        <span v-if="project.users.length > 3" class="remaining-users-amount">+{{project.users.length - 3}}</span>
                    </div>
                    <div class="col-md-6 flex-vertical-align justify-content-start">
                        <button class="cta btn btn-primary" @click="inviteUsersModalActive = true">Manage & Invite <i class="fas fa-plus"></i></button>
                    </div>
                </div>
            </div>
            <manage-staff-modal v-if="inviteUsersModalActive === true" :project="project" @manage-project-staff-modal-closed="inviteUsersModalActive = false" project-users-updated="loadUsers"></manage-staff-modal>
        </div>
    </div>
</template>

<script>
    import ManageStaffModal from '../../../../../../../components/modals/project/staff/manage-project-staff-modal.vue'

    export default {
        name: "team",
        components: {
            ManageStaffModal
        },
        props: ['project','user'],
        data() {
          return {
              users: [],
              projectOwner: this.user.id,
              inviteUsersModalActive: false
          }
        },
        mounted() {
          this.loadUsers();
        },
        methods: {
            loadUsers() {
                axios.get('/api/user?all=true')
                .then(response => {
                    response.data.forEach((user) => {
                        this.users.push(user);
                    });
                }).catch(function (error) {
                    console.log(error);
                });
            },
            updateProjectOwner() {
                let self = this;

                axios.put(this.$route('api.project.update', self.project.id), {project_owner_id: self.projectOwner})
                .then(response => {
                    if(response.data.status === 'success') {
                        this.$root.$emit('project_updated');
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            }
        }
    }
</script>
