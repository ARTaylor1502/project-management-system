<template>
    <div>
        <modal @close-modal="closeStaffManagementModal">
            <template slot="header">Manage Project Staff</template>
            <template slot="body">
                <template v-if="project.users.length > 0">
                    <h3>Current Staff Assigned to Project</h3>
                    <ul class="list">
                        <li class="list-item" v-for="user in project.users">
                            <span class="row">
                                <span class="col-md-10">{{user.full_name}}</span>
                                <span class="col-md-2 right-container">
                                    <span class="item-toggle" @click="removeUserFromProject(user)">
                                        <i class="remove-item fas fa-minus-circle"></i>
                                    </span>
                                </span>
                            </span>
                        </li>
                    </ul>
                </template>
                <p v-if="!project.users.length > 0">No Staff members currently assigned to Project</p>
                <button class="btn btn-primary" @click="addStaffMemberModalActive = true">Add Staff Member</button>
            </template>
        </modal>
        <add-staff-to-project-modal :project="project" v-if="addStaffMemberModalActive === true" @add-staff-member-to-project-modal-closed="addStaffMemberModalActive = false"></add-staff-to-project-modal>
    </div>
</template>

<script>
    import modal from '../../../modal'
    import addStaffToProjectModal from './add-staff-to-project-modal'

    export default {
        name: "manage-project-staff-modal",
        components: {
            modal,
            addStaffToProjectModal
        },
        props: ['project', 'users'],
        data() {
            return {
                errors: {},
                addStaffMemberModalActive: false
            }
        },
        methods: {
            closeStaffManagementModal() {
                this.$emit('manage-project-staff-modal-closed');
            },
            removeUserFromProject(user) {
                let self = this;

                axios.post('/api/project/'+self.project.id+'/user/remove', {
                    user_id: user.id
                })
                .then(response => {
                    if(response.data.status === 'success') {
                        self.$eventHub.$emit('project-updated');
                    } else if(response.data.status === 'error') {
                        //self.errors = response.data.errors;
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            }
        }
    }
</script>
