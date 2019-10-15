<template>
    <modal @close-modal="closeModal">
        <template slot="header">
            Edit Password
        </template>
        <template slot="body">
            <form @submit.prevent="editClientPasswordHandler">
                <div class="form-group">
                    <label class="col-form-label" for="edit_client_password_name">Name</label>
                    <input class="form-control" type="text" id="edit_client_password_name" name="edit_client_password_name" v-model="password.name"/>
                    <ul v-if="errors['name']" class="error-list">
                        <li v-for="error in errors['name']">{{error}}</li>
                    </ul>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="edit_client_password_url">URL</label>
                    <input class="form-control" type="text" id="edit_client_password_url" name="edit_client_password_url" v-model="password.url"/>
                    <ul v-if="errors['url']" class="error-list">
                        <li v-for="error in errors['url']">{{error}}</li>
                    </ul>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="edit_client_password_details">Details</label>
                    <textarea class="form-control" type="text" id="edit_client_password_details" name="edit_client_password_details" v-model="password.details"></textarea>
                    <ul v-if="errors['url']" class="error-list">
                        <li v-for="error in errors['url']">{{error}}</li>
                    </ul>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="edit_client_password_password">Password</label>
                    <input class="form-control" type="text" id="edit_client_password_password" name="edit_client_password_password" v-model="password.decrypted_password"/>
                    <ul v-if="errors['password']" class="error-list">
                        <li v-for="error in errors['password']">{{error}}</li>
                    </ul>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </template>
    </modal>
</template>

<script>
    import modal from '../../modal'

    export default {
        name: "edit-client-password-modal",
        components: {
            modal
        },
        props: ['password'],
        data() {
          return {
              errors: {},
              formData: {}
          }
        },
        methods: {
            editClientPasswordHandler() {
                this.populateFormData();
                this.editClientPassword();
            },
            editClientPassword() {
                let self = this;

                axios.post('/api/client/password/'+self.password.id+'/update', self.formData)
                .then(response => {
                    if(response.data.status === 'success') {
                        self.closeModal();
                        self.$emit('client-password-updated', response.data.message);
                    } else if(response.data.status === 'error') {
                        self.errors = response.data.errors;
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            },
            populateFormData() {
                this.formData = {
                    name : this.password.name,
                    url : this.password.url,
                    details : this.password.details,
                    password : this.password.decrypted_password
                }
            },
            closeModal() {
                this.$emit('edit-client-password-modal-closed');
            }
        }
    }
</script>
