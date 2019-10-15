<template>
    <modal @close-modal="closeModal">
        <template slot="header">
            Add New Document
        </template>
        <template slot="body">
            <file-validator :fileSelectorClasses="'col-md-12'"
                            :buttonClasses="'full-width'"
                            :errorContainerClasses="'col-md-12'">
                <template slot="button-text">Add Documents</template>
                <template slot="bottom-text">
                    <span class="caveat">Accepts: .doc, .docx, .gif, .jpg, .jpeg, .pdf, .png, .xls, .xlsx, .zip</span>
                    <span class="caveat">Maximum File Size: 24 MB</span>
                </template>
            </file-validator>
            <div v-if="errors" class="form-group">
                <ul  class="error-list">
                    <li v-for="(e, i) in errors">
                        <ul v-for="error in errors[i]">
                            {{error}}
                        </ul>
                    </li>
                </ul>
            </div>
        </template>
    </modal>
</template>

<script>
    import modal from '../../modal'
    import fileValidator from '../../file-validator'

    export default {
        name: "add-document-modal",
        components: {
            modal,
            fileValidator
        },
        props: ['base_folder_name', 'item_id', 'category'],
        data() {
            return {
                formData: {},
                files: [],
                errors: {}
            }
        },
        mounted() {
            this.$eventHub.$on('files-validated', this.filesValidatedHandler);
        },
        methods: {
            filesValidatedHandler(files) {
                this.files = files;
                this.addDocuments();
            },
            populateForm() {
                this.formData = new FormData();

                this.formData.append('category', this.category);

                for(let i = 0; i < this.files.length; i++ ){
                    let file = this.files[i];
                    this.formData.append('files[' + i + ']', file);
                }
            },
            addDocuments() {
                let self = this;

                self.populateForm();

                axios.post(this.$route('api.file.add.file', self.base_folder_name, self.item_id), self.formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(response => {
                    if(response.data.status === 'success') {
                        self.closeModal();
                        self.$emit('documents-added', response.data.message);
                    }
                }).catch(function (error) {
                    if(error.response) {
                        self.errors = error.response.data.errors;
                    }
                });
            },
            closeModal() {
                this.$emit('add-document-modal-closed');
            }
        }
    }
</script>
