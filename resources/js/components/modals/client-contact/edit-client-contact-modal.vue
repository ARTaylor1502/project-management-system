<template>
    <modal @close-modal="closeModal">
        <template slot="header">
            Edit Client Contact
        </template>
        <template slot="body">
            <form @submit.prevent="editClientContactHandler">
                <div class="form-group">
                    <label class="col-form-label" for="edit_client_first_name">First Name</label>
                    <input class="form-control" type="text" id="edit_client_first_name" name="edit_client_first_name" v-model="client_contact.first_name"/>
                    <ul v-if="errors['first_name']" class="error-list">
                        <li v-for="error in errors['first_name']">{{error}}</li>
                    </ul>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="edit_client_last_name">Last Name</label>
                    <input class="form-control" type="text" id="edit_client_last_name" name="edit_client_last_name" v-model="client_contact.last_name"/>
                    <ul v-if="errors['last_name']" class="error-list">
                        <li v-for="error in errors['last_name']">{{error}}</li>
                    </ul>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="edit_client_email">Email</label>
                    <input class="form-control" type="email" id="edit_client_email" name="edit_client_email" v-model="client_contact.email" readonly="true"/>
                    <ul v-if="errors['email']" class="error-list">
                        <li v-for="error in errors['email']">{{error}}</li>
                    </ul>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="edit_client_landline_tele">Landline Telephone</label>
                    <input class="form-control" type="text" id="edit_client_landline_tele" name="edit_client_landline_tele" v-model="client_contact.landline_tele"/>
                    <ul v-if="errors['landline_tele']" class="error-list">
                        <li v-for="error in errors['landline_tele']">{{error}}</li>
                    </ul>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="edit_client_mobile_number">Mobile Number</label>
                    <input class="form-control" type="text" id="edit_client_mobile_number" name="edit_client_mobile_number" v-model="client_contact.mobile_number"/>
                    <ul v-if="errors['mobile_number']" class="error-list">
                        <li v-for="error in errors['mobile_number']">{{error}}</li>
                    </ul>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="is_primary_contact">Primary Contact?</label>
                    <input type="checkbox" id="is_primary_contact" name="is_primary_contact" v-model="client_contact.is_primary_contact"/>
                    <ul v-if="errors['is_primary_contact']" class="error-list">
                        <li v-for="error in errors['is_primary_contact']">{{error}}</li>
                    </ul>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </template>
    </modal>
</template>

<script>
    import modal from '../../modal'

    export default {
        name: "edit-client-contact-modal",
        components: {
            modal
        },
        props: ['client_contact'],
        data() {
            return {
                errors: {},
                formData: {}
            }
        },
        methods: {
            editClientContactHandler() {
                this.populateFormData();
                this.editClientContact();
            },
            editClientContact() {
                let self = this;

                axios.post('/api/client/'+self.client_contact.client_id+'/contact/'+self.client_contact.id+'/update', self.formData)
                .then(response => {
                    if(response.data.status === 'success') {
                        self.closeModal();
                        self.$emit('client-contact-updated', response.data.message);
                    } else if(response.data.status === 'error') {
                        self.errors = response.data.errors;
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            },
            populateFormData() {
                this.formData = {
                    id : this.client_contact.id,
                    client_id : this.client_contact.client_id,
                    first_name : this.client_contact.first_name,
                    last_name : this.client_contact.last_name,
                    email: this.client_contact.email,
                    landline_tele: this.client_contact.landline_tele,
                    mobile_number: this.client_contact.mobile_number,
                    is_primary_contact: this.client_contact.is_primary_contact
                }
            },
            closeModal() {
                this.$emit('edit-client-contact-modal-closed');
            }
        }
    }
</script>

<style scoped>

</style>
