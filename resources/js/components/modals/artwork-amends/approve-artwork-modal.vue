<template>
    <modal @close-modal="closeModal">
        <template slot="header">Confirm Approval</template>
        <template slot="body">
            <p class="mb-5">Do you wish to proceed with the approval of the selected artwork?</p>
            <div v-if="artwork !== null" class="summary row mb-5">
                <div class="col-sm-5">
                    <img class="preview" :src="artwork.src"/>
                </div>
                <div class="col-sm-7">
                    <h3>{{artwork.name}} </h3>
                    <h4 v-if="artwork.what3words_code !== null">What3Words Code: {{artwork.what3words_code}}</h4>
                    <h4 v-if="artwork.material !== null">Material: {{artwork.material}}</h4>
                    <h4 v-if="artwork.print_code !== null">Print Code: {{artwork.print_code}}</h4>
                    <h4>Size: W {{artwork.height}}mm x H {{artwork.width}}mm x D {{artwork.depth}}mm</h4>
                    <h4>Description: {{artwork.description}}</h4>
                </div>
            </div>
            <div class="text-center">
                <button class="btn btn-success mr-3" @click="approveArtwork">Yes</button>
                <button class="btn btn-danger"  @click="closeModal">No</button>
            </div>
        </template>
    </modal>
</template>

<script>
    import modal from '../../modal';

    export default {
        name: "approve-artwork-modal",
        components: {
            modal
        },
        props: {
            project_id: {
              type: Number,
              required: true
            },
            artwork: {
                type: Object,
                required: true
            },
            staff_id: {
                type: Number,
                required: false
            },
            client_id: {
                type: Number,
                required: false
            }
        },
        methods: {
            resetModalData: function (){
                Object.assign(this.$data, resetData());
            },
            approveArtwork() {
                let self = this, url;

                if (this.artwork !== null) {
                    let today = new Date();
                    let date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
                    let time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                    let dateTime = date + ' ' + time;
                    let formData = {};

                    if(this.staff_id) {
                        formData = {
                            internally_approved: 1,
                            internal_approver_id: this.staff_id,
                            internally_approved_at: dateTime
                        }
                    } else if(this.client_id) {
                        formData = {
                            internally_approved: this.artwork.internally_approved,
                            internal_approver_id: this.artwork.internal_approver_id,
                            internally_approved_at: this.artwork.internally_approved_at,
                            client_approved: 1,
                            client_approver_id: this.client_id,
                            client_approved_at: dateTime
                        }
                    }

                    if(this.artwork.artwork_id) {
                        url = 'api.project.update.amend';
                    } else{
                        url = 'api.project.update.artwork';
                    }

                    axios.put(this.$route(url, this.artwork.id), formData)
                    .then(response => {
                        if (response.data.status === 'success') {
                            self.$emit('artwork-approved', self.artwork.artwork_type.name + ' successfully approved');
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
            closeModal() {
                this.$emit('approve-artwork-modal-closed');
            }
        }
    }
</script>
