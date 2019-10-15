<template>
    <div>
        <div v-if="artwork_submitted" class="alert alert-success mb-0">
            <i class="fas fa-times cursor-pointer float-right" @click="artwork_submitted = false"></i>
            {{artwork_type}} successfully submitted for internal approval
        </div>
        <div v-if="!artwork_data_valid" class="alert alert-danger mb-0">
            <i class="fas fa-times cursor-pointer float-right" @click="artwork_data_valid = true"></i>
            Please ensure all {{artwork_type}} data fields are populated before submission
        </div>
        <div class="card-header">
            <input type="file" :id="_uid + 'file_selector'" :name="_uid + 'files[]'" ref="files" multiple aria-describedby="file_selector" @change="handleFileUploads">
            <label class="drag-drop-selector" :for="_uid + 'file_selector'">Upload for Approval <i class="fal fa-plus"></i><small>Click or drag and drop</small></label>
        </div>
        <div class="list-group list-group-striped">
            <div v-for="(a,key) in artwork" class="list-group-item">
                <div class="row">
                    <div class="col-sm-4 pr-5">
                        <div class="artwork-preview">
                            <img class="preview" :src="a.src"/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="col-form-label">Name</label>
                            <input class="form-control" type="text" v-model="a.name">
                        </div>
                        <template v-if="artwork_type === 'Site Survey'">
                            <div class="form-group">
                                <label class="col-form-label" :for="_uid + 'what3words_code' + key">What 3 Words Code</label>
                                <div class="input-group mb-3">
                                    <input class="form-control" type="text" :id="_uid + 'what3words_code' + key" :name="_uid + 'what3words_code' + key" v-model="a.what3words_code" readonly/>
                                    <div class="input-group-append">
                                        <span @click="$eventHub.$emit('get-what3words-code', key)" class="input-group-text cta">Get Code</span>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <template v-else>
                            <div class="form-group">
                                <label class="col-form-label">Print Code</label>
                                <input class="form-control" type="text" v-model="a.print_code">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Material</label>
                                <input class="form-control" type="text" v-model="a.material">
                            </div>
                        </template>
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="col-form-label">Width</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" v-model="a.width">
                                    <div class="input-group-append">
                                        <span class="input-group-text">mm</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label class="col-form-label">Height</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" v-model="a.height">
                                    <div class="input-group-append">
                                        <span class="input-group-text">mm</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label class="col-form-label">Depth</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" v-model="a.depth">
                                    <div class="input-group-append">
                                        <span class="input-group-text">mm</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 description-column pl-5">
                        <label class="col-form-label">Description</label>
                        <textarea class="form-control" v-model="a.description"></textarea>
                    </div>
                </div>
            </div>
            <div v-if="artwork.length > 0" class="text-center mt-5">
                <button class="btn btn-primary" @click="submitArtwork">Send for Internal Approval</button>
            </div>
        </div>
    </div>
</template>

<script>
    import ArtworkHelper from '../../../../../../../components/mixins/artwork-helper'

    export default {
        name: "add-new-artwork",
        props: ['project_id', 'user_id', 'artwork_type'],
        mixins: [ArtworkHelper],
        data() {
            return {
                artwork_submitted: false,
                artwork_data_valid: true
            }
        },
        mounted() {
            this.$eventHub.$on('update-artwork-what3words-code', this.updateArtworkWhat3WordsCode);
        },
        methods: {
            handleFileUploads() {
                this.resetArtwork();
                this.setFiles();
            },
            setFiles() {
                let uploadedFiles = this.$refs.files.files;

                for( var i = 0; i < uploadedFiles.length; i++ ){
                    this.getImagePreview(uploadedFiles[i]);
                }
            },
            getImagePreview(file){
                if ( /\.(jpe?g|png|gif)$/i.test(file.name) ) {
                    let reader = new FileReader();

                    reader.addEventListener("load", function(){
                        let new_artwork = {
                            file: file,
                            src: reader.result,
                            name: '',
                            width: '',
                            height: '',
                            depth: '',
                            description: ''
                        };

                        if(this.artwork_type === 'Site Survey') {
                            new_artwork.what3words_code = '';
                        } else {
                            new_artwork.print_code = '';
                            new_artwork.material = '';
                        }

                        this.artwork.push(new_artwork);
                    }.bind(this), false);

                    reader.readAsDataURL(file);
                }
            },
            submitArtwork() {
                let self = this;

                let formData = new FormData();

                for(var i = 0; i < this.artwork.length; i++) {
                    formData.append('artwork[' + i + '][creator_id]', this.user_id);
                    formData.append('artwork[' + i + '][file]', this.artwork[i].file);
                    formData.append('artwork[' + i + '][name]', this.artwork[i].name);
                    formData.append('artwork[' + i + '][width]', this.artwork[i].width);
                    formData.append('artwork[' + i + '][height]', this.artwork[i].height);
                    formData.append('artwork[' + i + '][depth]', this.artwork[i].depth);
                    formData.append('artwork[' + i + '][description]', this.artwork[i].description);

                    if(this.artwork_type === 'Site Survey') {
                        formData.append('artwork[' + i + '][what3words_code]', this.artwork[i].what3words_code);
                    } else {
                        formData.append('artwork[' + i + '][print_code]', this.artwork[i].print_code);
                        formData.append('artwork[' + i + '][material]', this.artwork[i].material);
                    }
                }

                if(this.validateArtworkDataPopulated()) {
                    axios.post(this.$route('api.project.store.artwork', this.project_id, this.artwork_type), formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(response => {
                        if(response.data.status === 'success') {
                            self.resetArtwork();
                            self.artwork_submitted = true;
                            self.$eventHub.$emit('artwork-updated', self.project_id);
                        } else if(response.data.status === 'error') {
                            self.errors = response.data.errors;
                        }
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else {
                    this.artwork_data_valid = false;
                }
            }
        }
    }
</script>
