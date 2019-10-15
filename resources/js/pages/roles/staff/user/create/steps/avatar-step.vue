<template>
    <div id="add_avatar_step" class="list-group-item">
        <h2>Avatar</h2>
        <div class="row">
            <div class="form-group col-md-12">
                <file-validator :fileSelectorClasses="'col-md-6'"
                                :buttonClasses="''"
                                :filesFormatsAccepted="['jpg', 'jpeg', 'png']"
                                :errorContainerClasses="'offset-md-1 col-md-5'">
                    <template slot="button-text">Add Avatar</template>
                    <template slot="bottom-text">
                        <span class="caveat">Accepts: .jpg, .jpeg, .png</span>
                        <span class="caveat">Maximum File Size: 24 MB</span>
                    </template>
                </file-validator>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "avatar-step",
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
                if(this.file !== null) {
                    this.$emit('avatar-step-complete', {
                        file: this.file
                    });
                } else {
                    this.$emit('avatar-step-incomplete');
                }
            }
        },
    }
</script>
