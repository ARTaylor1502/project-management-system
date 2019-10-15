<template>
    <div>
        <div class="card">
            <div class="card-body">
                <h3>Assign Labour</h3>
                <div class="row row-eq-height">
                    <div v-if="project_labour.length > 0" v-for="(labour, index) in project_labour" class="col-sm-3">
                        <div class="border additionals-container">
                            <div class="border-bottom p-4 d-flex">
                                <img v-if="labour.user.avatar_path" class="avatar sm" :src="labour.user.avatar_path"/>
                                <span v-else :title="labour.user.full_name" class="avatar-placeholder sm avatar user-logo-container mr-3">
                                    <i class="fal fa-user"></i>
                                </span>
                                <h4 class="align-self-center mb-0">{{labour.user.full_name}}</h4>
                            </div>
                            <div class="border-bottom p-4">
                                <label class="col-form-label" :for="index + '_labour_start_date'">Start Date</label>
                                <input class="form-control" :id="index + '_labour_start_date'" type="date" :value="labour.start_date" readonly/>
                                <label class="col-form-label" :for="index + '_labour_end_date'">End Date</label>
                                <input class="form-control" :id="index + '_labour_end_date'" type="date" :value="labour.end_date" readonly/>
                            </div>
                            <div class="border-bottom p-4">
                                <label class="col-form-label" :for="index + '_responsibilities'">Project Responsibilities</label>
                                <textarea class="form-control" :id="index + '_responsibilities'" :value="labour.responsibilities" readonly></textarea>
                            </div>
                            <div class="p-4">
                                <p><i class="far fa-envelope"></i> {{labour.user.email}}</p>
                                <p><i class="far fa-mobile-alt"></i> {{labour.user.mobile_tele}}</p>
                                <p class="mb-0"><i class="fas fa-phone"></i> {{labour.user.landline_tele}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <button class="card primary-custom box-button align-content-center mb-0 h-100" @click="addLabourModalActive = true">Assign Labour <i class="fal fa-plus"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <add-new-project-labour-modal v-if="addLabourModalActive === true"
                                         :project_id="project_id"
                                         @add-new-project-labour-modal-closed="addLabourModalActive = false"
                                         @project-labour-added="projectLabourAddedHandler">
        </add-new-project-labour-modal>
        <modal v-show="successModalActive"
               @close-modal="successModalActive = false">
            <template slot="header">Success</template>
            <template slot="body">{{successBodyContent}}</template>
        </modal>
    </div>
</template>

<script>
    import AddNewProjectLabourModal from '../../../../../../components/modals/labour/add-new-project-labour-modal'
    import modal from '../../../../../../components/modal'

    export default {
        name: "labour",
        props: ['project_id'],
        components: {
            AddNewProjectLabourModal,
            modal
        },
        data() {
            return {
                addLabourModalActive: false,
                successModalActive: false,
                successBodyContent: '',
                project_labour: [],
                formData: null,
            }
        },
        created() {
            this.loadProjectLabour();
        },
        methods: {
            loadProjectLabour() {
                let self = this;

                axios.get(this.$route('api.project.labour.list', this.project_id))
                .then(response => {
                    self.project_labour = [];

                    response.data.forEach(function(labour) {
                        self.project_labour.push(labour);
                    });
                }).catch(function (error) {
                    console.log(error);
                });
            },
            projectLabourAddedHandler(e) {
                this.loadProjectLabour();
                this.addLabourModalActive = false;
                this.showSuccessModal(e.message);
            },
            showSuccessModal(message) {
                this.successBodyContent = message;
                this.successModalActive = true;
            },
        }
    }
</script>
