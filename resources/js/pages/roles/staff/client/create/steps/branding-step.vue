<template>
    <div id="add_client_branding_step" class="list-group-item">
        <h2>Branding</h2>
        <div class="row">
            <div class="form-group col-md-12">
                <file-validator :fileSelectorClasses="'col-md-6'"
                                :buttonClasses="''"
                                :filesFormatsAccepted="['jpg', 'jpeg', 'png']"
                                :errorContainerClasses="'offset-md-1 col-md-5'">
                    <template slot="button-text">Add Client Logo</template>
                    <template slot="bottom-text">
                        <span class="caveat">Accepts: .jpg, .jpeg, .png</span>
                        <span class="caveat">Maximum File Size: 24 MB</span>
                    </template>
                </file-validator>
            </div>
            <div class="form-group col-md-6">
                <label class="col-form-label" for="company_colour">Company Colour</label>
                <input v-model="company_colour" class="form-control" id="company_colour" name="company_colour" type="color" @change="infoChanged">
            </div>
            <ul v-if="errors['company_colour']" class="error-list">
                <li v-for="error in errors['company_colour']">{{error}}</li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        name: "branding-step",
        props: {
            errors: Object
        },
        data() {
            return {
                file: null,
                company_colour: ''
            }
        },
        created() {
            this.$eventHub.$on('files-validated', this.filesValidatedHandler);
        },
        methods: {
            filesValidatedHandler(file) {
                this.file = file;
                this.infoChanged();
            },
            infoChanged() {
                if(this.company_colour !== '' && this.file !== null) {
                    this.$emit('branding-step-complete', {
                        file: this.file,
                        company_colour: this.company_colour
                    });
                } else {
                    this.$emit('branding-step-incomplete');
                }
            }
        },
    }
</script>
