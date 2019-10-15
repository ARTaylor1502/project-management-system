<template>
    <li id="add_project_client_step" class="list-group-item">
        <h2>Client</h2>
        <div class="row">
            <div class="col-md-6">
                <label class="col-form-label" for="client_id">Client Name</label>
                <dropdown
                        :label="'Select a Client...'"
                        :options="clients"
                        :id="'client_id'"
                        :triggerName = "'Add New +'"
                        value-key="id"
                        label-key="name"
                        @input-selected="clientNameHandler"
                        @trigger-activated="addClientModalActive = true">
                </dropdown>
            </div>
            <div class="col-md-6" v-if="client.id">
                <label class="col-form-label" for="client_contact_id">Client Contact</label>
                <dropdown
                        :label="client_contact_label"
                        :options="client_contacts"
                        :id="'client_contact_id'"
                        :triggerName = "'Add New +'"
                        :labelSeparator="' '"
                        value-key="id"
                        label-key="full_name"
                        label-key2="primary_contact_label"
                        @input-selected="clientContactHandler"
                        @trigger-activated="addClientContactModalActive = true">
                </dropdown>
            </div>
        </div>
        <add-client-modal v-show="addClientModalActive"
               @client-added="clientAddedHandler"
               @client-modal-closed="addClientModalActive = false">
        </add-client-modal>
        <add-client-contact-modal v-show="addClientContactModalActive === true"
               :client="client"
               @client-contact-added="clientContactAddedHandler"
               @client-contact-modal-closed="addClientContactModalActive = false">
        </add-client-contact-modal>
        <modal v-show="successModalActive === true"
               @close-modal="closeSuccessModal">
               <template slot="header">Success</template>
               <template slot="body">{{successBodyContent}}</template>
        </modal>
    </li>
</template>

<script>
    import dropdown from '../../../../../../../components/drop-down'
    import modal from '../../../../../../../components/modal'
    import addClientModal from '../../../../../../../components/modals/client/add-client-modal'
    import addClientContactModal from '../../../../../../../components/modals/client-contact/add-client-contact-modal'
    import ClientHelper from '../../../../../../../components/mixins/client-helper'

    export default {
        name: "client-step",
        components: {
            dropdown,
            modal,
            addClientModal,
            addClientContactModal
        },
        mixins: [ClientHelper],
        data() {
            return {
                errors: {},
                client: {},
                client_contact: {},
                client_contact_label: 'Select a Client Contact...',
                client_contacts: [],
                addClientModalActive: false,
                addClientContactModalActive: false,
                successModalActive: false,
                successBodyContent: ''
            }
        },
        mounted(){
            this.loadClients({all:true});
            this.$eventHub.$emit('new-client-added', this.clientAddedHandler);
        },
        methods: {
            infoChanged() {
                if(this.client.id && this.client_contact.id) {
                    this.$emit('client-step-complete', {
                        client: this.client,
                        client_contact: this.client_contact
                    });
                } else {
                    this.$emit('client-step-incomplete');
                }
            },
            clientNameHandler(e) {
                this.client = e;
                this.loadClientContacts(this.client.id);
                this.infoChanged();
            },
            clientContactHandler(e) {
                this.client_contact = e;
                this.infoChanged();
            },
            clientAddedHandler(client_added_message) {
                this.showSuccessModal(client_added_message);
                this.loadClients();
            },
            clientContactAddedHandler(client_contact_added_message) {
                this.showSuccessModal(client_contact_added_message);
                this.loadClientContacts();
            },
            showSuccessModal(modal_content) {
                this.successBodyContent = modal_content;
                this.successModalActive = true;
            },
            closeSuccessModal() {
                this.successModalActive = false;
            }
        }
    }
</script>
