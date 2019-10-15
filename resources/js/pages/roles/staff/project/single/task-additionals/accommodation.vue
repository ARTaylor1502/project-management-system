<template>
    <div>
        <div class="card">
            <div class="card-body">
                <h3>Assign Accommodation</h3>
                <div v-if="project_accommodation.length > 0" v-for="(accommodation, index) in project_accommodation" class="additionals-container mb-3 border">
                    <div class="p-4 border-bottom">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4>{{accommodation.venue.name}}</h4>
                                <p><i class="far fa-map-marker-alt"></i> {{accommodation.venue.address_first_line}}, {{accommodation.venue.address_town}}, {{accommodation.venue.address_county}}, {{accommodation.venue.address_postcode}}</p>
                                <p v-if="accommodation.venue.car_park_type"><i class="far fa-parking"></i> {{accommodation.venue.car_park_type}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="p-4 w-60 border-right">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label class="col-form-label" :for="index + 'accommodation_number_of_rooms'">Number of Rooms</label>
                                    <input class="form-control" :id="index + 'accommodation_number_of_rooms'" type="number" :value="accommodation.number_of_rooms" readonly/>
                                </div>
                                <div class="col-sm-4">
                                    <label class="col-form-label" :for="index + 'accommodation_check_in'">Check In Date</label>
                                    <input class="form-control" :id="index + 'accommodation_check_in'" type="date" :value="accommodation.check_in" readonly/>
                                </div>
                                <div class="col-sm-4">
                                    <label class="col-form-label" :for="index + 'accommodation'">Check Out Date</label>
                                    <input class="form-control" :id="index + 'accommodation'" type="date" :value="accommodation.check_out" readonly/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <label class="col-form-label" :for="index + 'notes'">Notes</label>
                                    <textarea class="form-control" :id="index + 'notes'" :value="accommodation.notes" readonly></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 w-50">
                            <tabs>
                                <tab name="Add New Attachment" selected="selected">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <file-validator :fileSelectorClasses="'col-md-12'"
                                                            :buttonClasses="'sm'"
                                                            :filesFormatsAccepted="['doc', 'docx', 'gif', 'jpg', 'jpeg', 'pdf', 'png', 'xls', 'xlsx', 'zip']"
                                                            :errorContainerClasses="'col-md-12'"
                                                            @clicked="selected_accommodation = accommodation">
                                                <template slot="button-text">Add New Attachment</template>
                                                <template slot="bottom-text">
                                                    <span class="caveat">Accepts: .doc, .docx, .gif, .jpg, .jpeg, .pdf, .png, .xls, .xlsx, .zip</span>
                                                    <span class="caveat mb-3">Maximum File Size: 24 MB</span>
                                                </template>
                                            </file-validator>
                                        </div>
                                    </div>
                                </tab>
                                <tab name="Existing Attachments">
                                    <template v-if="accommodation.attachments.length > 0">
                                        <div class="list">
                                            <div v-for="attachment in accommodation.attachments" class="list-item d-flex align-items-center mb-3 bg-white">
                                                <div class="mr-auto">{{attachment.name}}</div>
                                                <a :href="attachment.src" download class="btn btn-primary btn-sm cta-item"><i class="fal fa-download"></i></a>
                                            </div>
                                        </div>
                                    </template>
                                    <p v-else>No existing attachments found</p>
                                </tab>
                            </tabs>
                        </div>
                    </div>
                </div>
                <p v-else>No accommodation found</p>
                <button class="btn primary-custom" @click="addAccommodationVenueModalActive = true">Add New Accommodation <i class="fal fa-plus"></i></button>
            </div>
        </div>
        <add-new-project-accommodation-modal v-if="addAccommodationVenueModalActive"
                                             :project_id="project_id"
                                             @show-add-venue-modal="addVenueModalActive = true"
                                             @add-new-project-accommodation-modal-closed="addAccommodationVenueModalActive = false"
                                             @project-accommodation-added="projectAccommodationAddedHandler">
        </add-new-project-accommodation-modal>
        <add-venue-modal v-if="addVenueModalActive"
                         @venue-added="showSuccessModal"
                         @venue-modal-closed="addVenueModalActive = false">
        </add-venue-modal>
        <modal v-show="successModalActive"
               @close-modal="successModalActive = false">
            <template slot="header">Success</template>
            <template slot="body">{{successBodyContent}}</template>
        </modal>
    </div>
</template>

<script>
    import AddNewProjectAccommodationModal from '../../../../../../components/modals/accomodation/add-new-project-accommodation'
    import AddVenueModal from '../../../../../../components/modals/venue/add-venue-modal'
    import modal from '../../../../../../components/modal'

    export default {
        name: "accommodation",
        props: ['project_id', 'what3words_api_key'],
        components: {
            AddNewProjectAccommodationModal,
            AddVenueModal,
            modal
        },
        data() {
            return {
                addAccommodationVenueModalActive: false,
                addVenueModalActive: false,
                successModalActive: false,
                successBodyContent: '',
                project_accommodation: [],
                files: null,
                formData: null,
                selected_accommodation: null
            }
        },
        created() {
            this.loadProjectAccommodation();
            this.$eventHub.$on('files-validated', this.filesValidatedHandler);
        },
        methods: {
            loadProjectAccommodation() {
                let self = this;

                axios.get(this.$route('api.project.accommodation.list', this.project_id))
                .then(response => {
                    self.project_accommodation = [];

                    response.data.forEach(function(accommodation) {
                        self.project_accommodation.push(accommodation);
                    });
                }).catch(function (error) {
                    console.log(error);
                });
            },
            filesValidatedHandler(files) {
                this.files = files;
                this.populateForm();
                this.addAttachments();
            },
            populateForm() {
                this.formData = new FormData();

                for(let i = 0; i < this.files.length; i++ ){
                    let file = this.files[i];
                    this.formData.append('files[' + i + ']', file);
                }
            },
            addAttachments() {
                let self = this;

                axios.post(this.$route('api.project.store.accommodation.attachments', self.selected_accommodation.id), self.formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(response => {
                    if(response.data.status === 'success') {
                        this.files = [];
                        this.loadProjectAccommodation();
                        this.showSuccessModal(response.data.message);
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            },
            projectAccommodationAddedHandler(e) {
                this.loadProjectAccommodation();
                this.addAccommodationVenueModalActive = false;
                this.showSuccessModal(e.message);
            },
            showSuccessModal(message) {
                this.successBodyContent = message;
                this.successModalActive = true;
            },
        }
    }
</script>
