<template>
    <modal @close-modal="closeModal">
        <template slot="header">Amends Made Comparison</template>
        <template slot="body">
            <div class="row artwork-amends-modal-container">
                <div class="col-sm-6 pr-5">
                    <h3>Previous Artwork</h3>
                    <div class="artwork-container mb-5">
                        <artwork-preview :artwork_src="previous_artwork.src"></artwork-preview>
                    </div>
                    <h3>{{previous_artwork.name}}</h3>
                    <h4 v-if="previous_artwork.material !== null">Material: {{previous_artwork.material}}</h4>
                    <h4>Size: W {{previous_artwork.height}}mm x H {{previous_artwork.width}}mm x D {{previous_artwork.depth}}mm</h4>
                    <h4>Description: {{previous_artwork.description}}</h4>
                </div>
                <div class="col-sm-6 pl-5">
                    <h3>Amended Artwork</h3>
                    <div class="artwork-container mb-5">
                        <artwork-preview :artwork_src="amended_artwork.src"></artwork-preview>
                    </div>
                    <h3>{{amended_artwork.name}} </h3>
                    <h4 v-if="amended_artwork.material !== null">Material: {{amended_artwork.material}}</h4>
                    <h4>Size: W {{amended_artwork.height}}mm x H {{amended_artwork.width}}mm x D {{amended_artwork.depth}}mm</h4>
                    <h4>Description: {{amended_artwork.description}}</h4>
                </div>
            </div>
            <div class="text-center mt-5">
                <button class="btn btn-success mr-3" @click="approveArtwork">Approve <i class="fas fa-check-square"></i></button>
                <button class="btn btn-danger" @click="requestAmends(amended_artwork)">Request Amends <i class="fas fa-edit"></i></button>
            </div>
        </template>
    </modal>
</template>

<script>
    import modal from '../../modal';
    import ArtworkPreview from "../../../pages/roles/staff/project/single/tabs/project-journey/artwork-preview";

    export default {
        name: "amends-made-comparison-modal",
        props: {
            project_id: {
                type: Number,
                required: true
            },
            staff_id: {
                type: Number,
                required: false
            },
            client_id: {
                type: Number,
                required: false
            },
            amend_request: {
                type: Object,
                required: true
            },
            previous_artwork: {
                type: Object,
                required: true
            },
            amended_artwork: {
                type: Object,
                required: true
            }
        },
        components: {
            ArtworkPreview,
            modal
        },
        methods: {
            approveArtwork() {
                let self = this, formData;

                if (this.artwork !== null) {
                    let today = new Date();
                    let date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
                    let time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                    let dateTime = date + ' ' + time;

                    if(this.staff_id) {
                        formData = {
                            internally_approved: 1,
                            internal_approver_id: this.staff_id,
                            internally_approved_at: dateTime
                        }
                    } else if(this.client_id) {
                        formData = {
                            client_approved: 1,
                            client_approver_id: this.client_id,
                            client_approved_at: dateTime
                        }
                    }

                    axios.put(this.$route('api.project.update.amend', this.amended_artwork.id), formData)
                    .then(response => {
                        if (response.data.status === 'success') {
                             self.$emit('amend-approved', response.data.message);
                             self.$eventHub.$emit('artwork-updated', self.project_id);
                             self.closeModal();
                        } else if (response.data.status === 'error') {
                            self.errors = response.data.errors;
                        }
                    }).catch(function (error) {
                        console.log(error);
                    });
                }
            },
            requestAmends(artwork) {
                this.closeModal();
                this.$eventHub.$emit('request-artwork-amends', artwork);
            },
            closeModal() {
                this.$emit('amends-made-modal-closed');
            }
        }
    }
</script>
