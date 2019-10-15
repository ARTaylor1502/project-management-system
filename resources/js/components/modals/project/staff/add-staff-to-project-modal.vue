<template>
    <div>
        <modal @close-modal="closeAddStaffMemberToProjectModal">
            <template slot="header"> Add Staff Member to Project</template>
            <template slot="body">
                <form @submit.prevent="addStaffMemberToProject()">
                    <div class="form-group">
                        <template v-if="availableStaff.length > 0">
                            <label>Staff member</label>
                            <select class="form-control" v-model="selectedStaffMember">
                                <option v-for="staff in availableStaff" :value="staff.id">{{staff.full_name}}</option>
                            </select>
                        </template>
                        <p v-if="!availableStaff.length > 0">No staff members available</p>
                    </div>
                    <button type="submit" class="btn btn-primary">Add</button>
                </form>
            </template>
        </modal>
        <modal v-if="successModalActive === true" @close-modal="successModalActive = false">
            <template slot="body">{{successModalBodyContent}}</template>
        </modal>
    </div>
</template>

<script>
    import modal from '../../../modal'

    export default {
        name: "add-staff-to-project-modal",
        components: {
            modal
        },
        props: ['project'],
        data() {
            return {
                availableStaff: [],
                selectedStaffMember: null,
                successModalBodyContent: '',
                successModalActive: false
            }
        },
        created() {
            this.loadAvailableStaff();
        },
        methods: {
            loadAvailableStaff() {
                let self = this;

                self.availableStaff = [];

                axios.get(this.$route('api.project.available.users', self.project.id))
                    .then(response => {
                        response.data.forEach((user) => {
                            self.availableStaff.push(user);
                        });

                        if(self.availableStaff.length > 0) {
                            self.selectedStaffMember = self.availableStaff[0].id;
                        }
                    }).catch(function (error) {
                    console.log(error);
                });
            },
            addStaffMemberToProject() {
                let self = this;

                axios.post(this.$route('api.project.add.user', self.project.id), {
                    user_id: self.selectedStaffMember
                })
                .then(response => {
                    if(response.data.status === 'success') {
                        self.loadAvailableStaff();
                        self.initSuccessMessage(response.data.message);
                        self.$eventHub.$emit('project-updated');
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            },
            initSuccessMessage(message) {
                this.successModalActive = true;
                this.successModalBodyContent = message;
            },
            closeAddStaffMemberToProjectModal() {
                this.$emit('add-staff-member-to-project-modal-closed');
            }
        }
    }
</script>
