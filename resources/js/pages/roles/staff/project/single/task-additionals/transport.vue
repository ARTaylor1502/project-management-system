<template>
    <div>
        <div class="card">
            <div class="card-body">
                <h3>Assign Transport</h3>
                <div class="row row-eq-height">
                    <div v-if="project_transport.length > 0" v-for="(transport, index) in project_transport" class="col-sm-2">
                        <div class="border additionals-container">
                            <div class="border-bottom p-4">
                                <h4>{{transport.name}}</h4>
                                <h4 class="mb-0">{{transport.vehicle_type.name}}</h4>
                            </div>
                            <div class="border-bottom p-4">
                                <label class="col-form-label" :for="index + 'transport_start_date'">Start Date</label>
                                <input class="form-control" :id="index + 'transport_start_date'" type="date" :value="transport.start_date" readonly/>
                                <label class="col-form-label" :for="index + 'transport_end_date'">End Date</label>
                                <input class="form-control" :id="index + 'transport_end_date'" type="date" :value="transport.end_date" readonly/>
                            </div>
                            <div class="border-bottom p-4">
                                <label class="col-form-label" :for="index + 'notes'">Notes</label>
                                <textarea class="form-control" :id="index + 'notes'" :value="transport.notes" readonly></textarea>
                            </div>
                            <div class="p-4">
                                <p><i class="far fa-building"></i> {{transport.rental_company}}</p>
                                <p><i class="far fa-car"></i> {{transport.license_plate}}</p>
                                <p class="mb-0"><i class="far fa-palette"></i> {{transport.colour}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <button class="card primary-custom box-button align-content-center mb-0 h-100" @click="addTransportModalActive = true">Assign Vehicle <i class="fal fa-plus"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <add-new-project-transport-modal v-if="addTransportModalActive === true"
                                         :project_id="project_id"
                                         @add-new-project-transport-modal-closed="addTransportModalActive = false"
                                         @project-transport-added="projectTransportAddedHandler">
        </add-new-project-transport-modal>
        <modal v-show="successModalActive"
               @close-modal="successModalActive = false">
            <template slot="header">Success</template>
            <template slot="body">{{successBodyContent}}</template>
        </modal>
    </div>
</template>

<script>
    import modal from '../../../../../../components/modal'
    import AddNewProjectTransportModal from '../../../../../../components/modals/transport/add-new-project-transport'

    export default {
        name: "transport",
        props: ['project_id'],
        components: {
            modal,
            AddNewProjectTransportModal
        },
        data() {
            return {
                addTransportModalActive: false,
                successModalActive: false,
                successBodyContent: '',
                project_transport: [],
                formData: null,
            }
        },
        created() {
            this.loadProjectTransport();
        },
        methods: {
            loadProjectTransport() {
                let self = this;

                axios.get(this.$route('api.project.transport.list', this.project_id))
                .then(response => {
                    self.project_transport = [];

                    response.data.forEach(function(transport) {
                        self.project_transport.push(transport);
                    });
                }).catch(function (error) {
                    console.log(error);
                });
            },
            projectTransportAddedHandler(e) {
                this.loadProjectTransport();
                this.addTransportModalActive = false;
                this.showSuccessModal(e.message);
            },
            showSuccessModal(message) {
                this.successBodyContent = message;
                this.successModalActive = true;
            },
        }
    }
</script>
