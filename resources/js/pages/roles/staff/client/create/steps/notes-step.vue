<template>
    <div id="add_client_notes_step" class="list-group-item">
        <h2>Private Notes</h2>
        <div class="row">
            <div class="col-md-12">
                <editor v-model="notes" :init="{ branding: false, statusbar: false, menubar: false, height: 400}" plugins="link lists code" toolbar="undo redo formatselect bold italic alignleft aligncenter alignright alignjustify bullist numlist outdent indent link code"></editor>
            </div>
            <ul v-if="errors['private_notes']" class="error-list">
                <li v-for="error in errors['private_notes']">{{error}}</li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        name: "notes-step",
        props: {
            errors: Object
        },
        data() {
            return {
                notes: '',
            }
        },
        watch: {
            notes: function () {
                if(this.notes !== '') {
                    this.$emit('notes-step-complete', {
                        private_notes: this.notes,
                    });
                } else {
                    this.$emit('notes-step-incomplete');
                }
            }
        }
    }
</script>