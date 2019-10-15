<template>
    <modal @close-modal="closeModal">
        <template slot="header">
            Add Password
        </template>
        <template slot="body">
            <form @submit.prevent="addClientPassword(client_id, formData)">
                <div class="form-group">
                    <label class="col-form-label" for="add_client_password_name">Name</label>
                    <input class="form-control" type="text" id="add_client_password_name" name="add_client_password_name" v-model="formData.name"/>
                    <ul v-if="errors['name']" class="error-list">
                        <li v-for="error in errors['name']">{{error}}</li>
                    </ul>
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="add_client_password_url">URL</label>
                    <input class="form-control" type="text" id="add_client_password_url" name="add_client_password_url" v-model="formData.url"/>
                    <ul v-if="errors['url']" class="error-list">
                        <li v-for="error in errors['url']">{{error}}</li>
                    </ul>
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="add_client_password_details">Details</label>
                    <textarea class="form-control" type="text" id="add_client_password_details" name="add_client_password_details" v-model="formData.details"></textarea>
                    <ul v-if="errors['url']" class="error-list">
                        <li v-for="error in errors['url']">{{error}}</li>
                    </ul>
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="add_client_password_password">Password</label>
                    <input class="form-control" type="password" id="add_client_password_password" name="add_client_password_password" v-model="formData.password"/>
                    <ul v-if="errors['password']" class="error-list">
                        <li v-for="error in errors['password']">{{error}}</li>
                    </ul>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </template>
    </modal>
</template>

<script>
    import modal from '../../modal'
    import ClientHelper from '../../../components/mixins/client-helper'

    export default {
        name: "add-client-password-modal",
        components: {
            modal
        },
        props: ['client_id'],
        mixins: [ClientHelper],
        data() {
          return {
              errors: {},
              formData: {}
          }
        },
        methods: {
            closeModal() {
                this.$emit('add-client-password-modal-closed');
            }
        }
    }
</script>
