<template>
    <li id="add_project_brief_step" class="list-group-item">
        <h2>Design Brief</h2>
        <div class="row">
            <div class="col-md-12">
                <editor v-model="brief" :init="{ branding: false, statusbar: false, menubar: false, height: 400}" plugins="link lists code" toolbar="undo redo formatselect bold italic alignleft aligncenter alignright alignjustify bullist numlist outdent indent link code"></editor>
            </div>
        </div>
        <div class="row">
            <h2>Attachments</h2>
            <div class="col-md-12">
                <file-validator :fileSelectorClasses="'col-md-6'"
                                :buttonClasses="''"
                                :errorContainerClasses="'offset-md-1 col-md-5'"
                                @files-validated="filesValidatedHandler">
                    <template slot="button-text">Add New Attachment(s)</template>
                    <template slot="bottom-text">
                        <span class="caveat">Accepts: .doc, .docx, .gif, .jpg, .jpeg, .pdf, .png, .xls, .xlsx, .zip</span>
                        <span class="caveat">Maximum File Size: 24 MB</span>
                    </template>
                </file-validator>
            </div>
        </div>
    </li>
</template>

<script>
    export default {
        name: "brief-step",
        data() {
            return {
                errors: {},
                brief: '',
                files: [],
                selected_attachment: null
            }
        },
        methods: {
            filesValidatedHandler(files) {
                this.files = files;
            }
        },
        watch: {
            brief: function () {
                if(this.brief !== '') {
                    this.$emit('brief-step-complete', {
                        brief: this.brief,
                        files: this.files
                    });
                } else {
                    this.$emit('brief-step-incomplete');
                }
            }
        }
    }
</script>