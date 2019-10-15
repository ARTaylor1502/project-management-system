<template>
    <div class="row">
        <div :class="fileSelectorClasses">
            <input type="file" id="file_selector" name="files[]" :multiple="is_multiple" aria-describedby="file_selector" @change="validateFiles">
            <label class="file-selector" :class="buttonClasses" for="file_selector" @click="$emit('clicked');"><slot name="button-text"></slot> <i class="fal fa-plus"></i></label>
            <span class="caveat">
                <slot name="bottom-text"></slot>
            </span>
        </div>
        <div :class="errorContainerClasses">
            <div class="form-group">
                <ul v-if="errors.length > 0" class="error-list">
                    <li v-for="(e, i) in errors">
                        <ul v-for="error in errors[i]">
                            {{error}}
                        </ul>
                    </li>
                </ul>
                <div v-if="files.length > 0">
                    <ul class="list-group">
                        <li class="list-group-item list-sm" v-for="file in files">{{file.name}} <i class="fas fa-check-circle success float-right"></i></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "file-validator",
        props: {
            is_multiple: {
                type: Boolean
            },
            filesFormatsAccepted: {
                type: Array
            },
            fileSelectorClasses: {
                type: String
            },
            buttonClasses: {
                type: String
            },
            errorContainerClasses: {
                type: String
            }
        },
        data() {
            return {
                files: [],
                errors: {}
            }
        },
        methods: {
            validateFiles(e) {
                let formData = new FormData();
                let self = this;

                self.files = e.target.files;
                self.errors = {};

                for( var i = 0; i < self.files.length; i++ ){
                    let file = self.files[i];
                    formData.append('files[' + i + ']', file);
                }

                if(self.filesFormatsAccepted) {
                    formData.append('file_types_accepted', self.filesFormatsAccepted)
                }

                axios.post(this.$route('api.file.validate'), formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(response => {
                    if(response.data.status === 'success') {
                        this.$eventHub.$emit('files-validated', self.files);
                    } else if(response.data.status === 'error') {
                        self.files = [];
                        self.errors = response.data.errors;
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            }
        }
    }
</script>
