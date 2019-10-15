<template>
    <modal @close-modal="closeModal">
        <template slot="header">Add Amended</template>
        <template slot="body">
            <template v-if="!newImageAdded">
                <input type="file" id="add_amend_file_selector" name="add_amend_file" ref="file" aria-describedby="file_selector" @change="handleFileUploads">
                <label class="drag-drop-selector" for="add_amend_file_selector">Upload for Approval <i class="fal fa-plus"></i><small>Click or drag and drop</small></label>
            </template>
            <div v-if="newImageAdded && !artwork_data_valid" class="alert alert-danger mb-5">
                <i class="fas fa-times cursor-pointer float-right" @click="artwork_data_valid = true"></i>
                Please ensure all artwork data fields are populated before submission
            </div>
            <div v-if="newImageAdded" class="list-group list-group-striped">
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <div class="artwork-preview">
                            <img class="preview" :src="amended_artwork.src"/>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-form-label">Name</label>
                            <input class="form-control" type="text" v-model="amended_artwork.name">
                        </div>
                        <template v-if="amended_artwork.what3words_code !== null">
                            <div class="form-group">
                                <label class="col-form-label" for="what3words_code">What 3 Words Code</label>
                                <div class="input-group mb-3">
                                    <input class="form-control" type="text" id="what3words_code" name="what3words_code" v-model="amended_artwork.what3words_code" readonly/>
                                    <div class="input-group-append">
                                        <span @click="$eventHub.$emit('get-what3words-code')" class="input-group-text cta">Get Code</span>
                                    </div>
                                </div>
                            </div>
                        </template>
                       <template v-else-if="amended_artwork.material !== null && amended_artwork.print_code !== null">
                           <div class="form-group">
                               <label class="col-form-label">Material</label>
                               <input class="form-control" type="text" v-model="amended_artwork.material">
                           </div>
                           <div class="form-group">
                               <label class="col-form-label">Print Code</label>
                               <input class="form-control" type="text" v-model="amended_artwork.print_code">
                           </div>
                       </template>
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="col-form-label">Width</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" v-model="amended_artwork.width">
                                    <div class="input-group-append">
                                        <span class="input-group-text">mm</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label class="col-form-label">Height</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" v-model="amended_artwork.height">
                                    <div class="input-group-append">
                                        <span class="input-group-text">mm</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label class="col-form-label">Depth</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" v-model="amended_artwork.depth">
                                    <div class="input-group-append">
                                        <span class="input-group-text">mm</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 description-column">
                        <label class="col-form-label">Description</label>
                        <textarea class="form-control" v-model="amended_artwork.description"></textarea>
                    </div>
                </div>
            </div>
            <div v-if="newImageAdded === true" class="text-center mt-5">
                <button class="btn btn-primary" @click="submitArtwork">Send for Internal Approval</button>
            </div>
        </template>
    </modal>
</template>

<script>
    import modal from '../../modal'

    export default {
        name: "add-amended-artwork",
        components: {
            modal
        },
        props: ['project_id', 'staff_id', 'artwork', 'amend_request_id'],
        data() {
            return {
                amended_artwork: {
                    src: '',
                    name: this.artwork.name,
                    what3words_code: this.artwork.what3words_code,
                    material: this.artwork.material,
                    print_code: this.artwork.print_code,
                    width: this.artwork.width,
                    height: this.artwork.height,
                    depth: this.artwork.depth,
                    description: this.artwork.description,
                    internally_approved: this.artwork.internally_approved,
                    internal_approver_id: this.artwork.internal_approver_id,
                    internally_approved_at: this.artwork.internally_approved_at
                },
                what3words_modal_active: false,
                newImageAdded: false,
                artwork_data_valid: true
            }
        },
        mounted() {
          this.$eventHub.$on('update-artwork-what3words-code', this.updateWhat3WordsCode);
        },
        methods: {
            handleFileUploads() {
                this.setFiles();
                this.newImageAdded = true;
            },
            setFiles() {
                let uploadedFiles = this.$refs.file.files;

                for (var i = 0; i < uploadedFiles.length; i++) {
                    this.getImagePreview(uploadedFiles[i]);
                }
            },
            getImagePreview(file){
                if ( /\.(jpe?g|png|gif)$/i.test(file.name) ) {
                    let reader = new FileReader();

                    reader.addEventListener("load", function(){
                        this.amended_artwork. file = file;
                        this.amended_artwork.src = reader.result;
                    }.bind(this), false);

                    reader.readAsDataURL(file);
                }
            },
            submitArtwork() {
                let self = this, formData = new FormData(), artwork_id;

                formData.append('creator_id', this.staff_id);
                formData.append('file', this.amended_artwork.file);
                formData.append('name', this.amended_artwork.name);
                formData.append('width', this.amended_artwork.width);
                formData.append('height', this.amended_artwork.height);
                formData.append('depth', this.amended_artwork.depth);
                formData.append('description', this.amended_artwork.description);
                formData.append('internally_approved', this.amended_artwork.internally_approved);
                formData.append('internal_approver_id', this.amended_artwork.internal_approver_id);
                formData.append('internally_approved_at', this.amended_artwork.internally_approved_at);

                if(this.amended_artwork.what3words_code !== null) {
                    formData.append('what3words_code', this.amended_artwork.what3words_code);
                } else if(this.amended_artwork.material !== null && this.amended_artwork.print_code !== null) {
                    formData.append('material', this.amended_artwork.material);
                    formData.append('print_code', this.amended_artwork.print_code);
                }

                if(this.artwork.artwork_id) {
                    artwork_id = this.artwork.artwork_id;
                } else {
                    artwork_id = this.artwork.id;
                }

                if(this.validateArtworkDataPopulated()) {
                    axios.post(this.$route('api.project.store.artwork.amend', artwork_id, this.amend_request_id), formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(response => {
                        if(response.data.status === 'success') {
                            self.$eventHub.$emit('artwork-updated', self.project_id);
                            self.$emit('artwork-amend-added', response.data.message);
                            self.closeModal();
                        } else if(response.data.status === 'error') {
                            self.errors = response.data.errors;
                        }
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else {
                    this.artwork_data_valid = false;
                }
            },
            validateArtworkDataPopulated() {
                var artwork_data_valid = true;

                for(var key in this.amended_artwork) {
                    if(this.amended_artwork[key] === "") {
                        artwork_data_valid = false;
                    }
                }

                return artwork_data_valid;
            },
            updateWhat3WordsCode(e) {
                this.amended_artwork.what3words_code = e.code;
            },
            closeModal() {
                this.$emit('add-amended-artwork-modal-closed');
            }
        }
    }
</script>
