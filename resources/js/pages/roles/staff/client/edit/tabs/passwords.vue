<template>
    <div>
        <div class="filters-container"><button class="cta btn btn-primary" @click="addClientPasswordModalActive = true">Add New Password <i class="fas fa-plus"></i></button></div>
        <div class="row row-eq-height">
            <div v-for="password in passwords" class="col-sm-4">
                <div class="card card-body h-100">
                    <span class="actions float-right">
                        <i class="fal fa-edit" @click="editPassword(password)"></i>
                        <i class="fal fa-trash-alt ml-2" @click="promptDeletePasswordConfirmation(password)"></i>
                    </span>
                    <h2>{{password.name}}</h2>
                    <span class="row mb-2">
                    <span class="col-sm-4"><strong>URL:</strong></span>
                    <span class="col-sm-8">{{password.url}}</span>
                </span>
                    <span class="row mb-2">
                    <span class="col-sm-4"><strong>Details:</strong></span>
                    <span class="col-sm-8">{{password.details}}</span>
                </span>
                    <span class="row mb-2">
                    <span class="col-sm-4"><strong>Password:</strong></span>
                    <span class="col-sm-8">{{password.decrypted_password}}</span>
                </span>
                    <span class="row mb-2">
                    <span class="col-sm-4"><strong>Updated:</strong></span>
                    <span class="col-sm-8">{{password.updated_at}}</span>
                </span>
                </div>
            </div>
        </div>
        <add-client-password-modal v-show="addClientPasswordModalActive === true"
                                    :client_id="client_id"
                                    @client-password-added="passwordAddedHandler"
                                    @add-client-password-modal-closed="addClientPasswordModalActive = false">
        </add-client-password-modal>
        <edit-client-password-modal v-show="editClientPasswordModalActive === true"
                                    :password="selected_password"
                                    @client-password-updated="passwordUpdatedHandler"
                                    @edit-client-password-modal-closed="editClientPasswordModalActive = false">
        </edit-client-password-modal>
        <delete-client-password-modal v-show="deleteClientPasswordModalActive === true"
                          @action-confirmed="deletePasswordHandler"
                          @delete-client-password-modal-closed="deleteClientPasswordModalActive = false">
        </delete-client-password-modal>

        <modal v-show="successModalActive === true"
               @close-modal="closeSuccessModal">
            <template slot="header">Success</template>
            <template slot="body">{{successBodyContent}}</template>
        </modal>
    </div>
</template>

<script>
    import AddClientPasswordModal from '../../../../../../components/modals/passwords/add-password-modal'
    import EditClientPasswordModal from '../../../../../../components/modals/passwords/edit-password-modal'
    import DeleteClientPasswordModal from '../../../../../../components/modals/passwords/delete-password-modal'
    import Modal from '../../../../../../components/modal'
    import ClientHelper from '../../../../../../components/mixins/client-helper'

    export default {
        name: "client-passwords",
        props: ['client_id', 'passwords'],
        components: {
            AddClientPasswordModal,
            DeleteClientPasswordModal,
            EditClientPasswordModal,
            Modal
        },
        mixins: [ClientHelper],
        data() {
          return {
              addClientPasswordModalActive: false,
              editClientPasswordModalActive: false,
              selected_password: {},
              deleteClientPasswordModalActive: false,
              successModalActive: false,
              successBodyContent: ''
          }
        },
        created() {
            this.$eventHub.$on('client-password-deleted', this.deletePasswordHandler);
            this.$eventHub.$on('client-password-added', this.passwordAddedHandler);
        },
        methods: {
            editPassword(password) {
                this.selected_password = password;
                this.editClientPasswordModalActive = true;
            },
            passwordAddedHandler(message) {
                this.addClientPasswordModalActive = false;
                this.showSuccessModal(message);
                this.$eventHub.$emit('client-updated', this.client_id);
            },
            passwordUpdatedHandler(message) {
                this.editClientPasswordModalActive = false;
                this.showSuccessModal(message);
                this.$eventHub.$emit('client-updated', this.client_id);
            },
            promptDeletePasswordConfirmation(password) {
                this.selected_password = password;
                this.deleteClientPasswordModalActive = true;
            },
            deletePasswordHandler(message) {
                this.deleteClientPasswordModalActive = false;
                this.deletePassword(this.selected_password.id);
                this.showSuccessModal(message);
                this.$eventHub.$emit('client-updated', this.client_id);
            },
            showSuccessModal(message) {
                this.successBodyContent = message;
                this.successModalActive = true;
            },
            closeSuccessModal() {
                this.successModalActive = false;
            }
        }
    }
</script>

<style scoped>

</style>
