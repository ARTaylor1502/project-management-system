<template>
    <transition name="modal" @close-modal="closeModal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <div class="modal-header modal-header-dark">
                        <div class="flex-start">
                            <h3 class="mb-3">Request Amends</h3>
                            <h3 class="mt-0 mb-5">{{artwork.name}}{{artwork.print_code? ' - ' + artwork.print_code : ''}}</h3>
                            <h4 v-if="artwork.material"><span class="modal-title">Material:</span> {{artwork.material}}</h4>
                            <h4 v-if="artwork.what3words_code"><span class="modal-title">What3Words Code:</span> {{artwork.what3words_code}}</h4>
                            <h4><span class="modal-title">Size:</span> W {{artwork.height}}mm x H {{artwork.width}}mm x D {{artwork.depth}}mm</h4>
                            <h4><span class="modal-title">Description:</span> {{artwork.description}}</h4>
                        </div>
                        <div class="flex-end">
                            <i class="fal fa-times close" @click="closeModal"></i>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Description of Amends</label>
                            <editor v-model="description" :init="{ branding: false, statusbar: false, menubar: false, height: 200}" plugins="link lists" toolbar="undo redo formatselect bold italic alignleft aligncenter alignright alignjustify bullist numlist link"></editor>
                        </div>
                        <file-validator :fileSelectorClasses="'col-md-12'"
                                        :buttonClasses="''"
                                        :filesFormatsAccepted="['doc', 'docx', 'gif', 'jpg', 'jpeg', 'pdf', 'png', 'xls', 'xlsx', 'zip']"
                                        :errorContainerClasses="'col-md-12 mt-4'">
                            <template slot="button-text">Add New Attachment</template>
                            <template slot="bottom-text">
                                <span class="caveat">Accepts: .doc, .docx, .gif, .jpg, .jpeg, .pdf, .png, .xls, .xlsx, .zip</span>
                                <span class="caveat">Maximum File Size: 24 MB</span>
                            </template>
                        </file-validator>
                        <div class="text-center" v-show="submitButtonActive === true">
                            <button class="btn btn-primary btn-lg mt-3" @click="submitAmendRequest">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        name: "request-amends-modal",
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
        data() {
            return resetData();
        },
        mounted() {
          this.$eventHub.$on('files-validated', this.filesValidatedHandler);
        },
        watch: {
            description: function () {
                this.submitButtonActive = this.description !== '';
            }
        },
        methods: {
            resetModalData: function (){
                Object.assign(this.$data, resetData());
            },
            closeModal() {
                this.$emit('request-amends-modal-closed');
            },
            filesValidatedHandler(file) {
                this.file = file;
            },
            submitAmendRequest() {
                let formData = new FormData(), artwork_id, self = this;

                formData.append('description', this.description);
                if(self.staff_id) {
                    formData.append('internal_requester_id', self.staff_id);
                } else if(self.client_id) {
                    formData.append('client_requester_id', self.client_id);
                }

                if(this.file !== null && this.file.length > 0) {
                    let file = self.file[0];
                    formData.append('file', file);
                }

                if(this.artwork.artwork_id) {
                    artwork_id = self.artwork.artwork_id;
                } else {
                    artwork_id = self.artwork.id;
                }

                axios.post(this.$route('api.project.store.artwork.amend.request', artwork_id), formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {
                    if(response.data.status === 'success') {
                        self.$emit('requested-amend-added', response.data.message);
                        self.$eventHub.$emit('artwork-updated', self.project_id);
                        self.closeModal();
                    } else if(response.data.status === 'error') {
                        self.errors = response.data.errors;
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            },
        }
    }

    function resetData() {
        return {
            error: '',
            description: '',
            file: null,
            submitButtonActive: false
        }
    }
</script>
