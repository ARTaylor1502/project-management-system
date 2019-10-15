<template>
    <div>
        <div class="card">
            <div class="list-group shadow">
                <div class="list-group-item">
                    <h2>Name</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="col-form-label" for="name">Company Name</label>
                            <input v-model="updatable_client_data.name" class="form-control" id="name" name="name" type="text">
                            <ul v-if="errors['name']" class="error-list">
                                <li v-for="error in errors['name']">{{error}}</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label" for="aliases">Aliases</label>
                            <input v-model="formatted_aliases" class="form-control" id="aliases" name="aliases" type="text" placeholder="Comma-separated list of names a client is also known as. This will show up in search results">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="col-form-label" for="company_colour">Company Colour</label>
                            <input v-model="updatable_client_data.company_colour" class="form-control" id="company_colour" name="company_colour" type="color">
                            <ul v-if="errors['company_colour']" class="error-list">
                                <li v-for="error in errors['company_colour']">{{error}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <h2>Details</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label" for="landline_tele">Landline Telephone</label>
                                <input v-model="updatable_client_data.landline_tele" class="form-control" id="landline_tele" name="landline_tele" type="text">
                                <ul v-if="errors['landline_tele']" class="error-list">
                                    <li v-for="error in errors['landline_tele']">{{error}}</li>
                                </ul>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label" for="mobile_number">Mobile Telephone</label>
                                <input v-model="updatable_client_data.mobile_number" class="form-control" id="mobile_number" name="mobile_number" type="text">
                                <ul v-if="errors['mobile_number']" class="error-list">
                                    <li v-for="error in errors['mobile_number']">{{error}}</li>
                                </ul>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label" for="website">Website</label>
                                <input v-model="updatable_client_data.website" class="form-control" id="website" name="website" type="text">
                                <ul v-if="errors['website']" class="error-list">
                                    <li v-for="error in errors['website']">{{error}}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label" for="account_manager">Primary Account Manager</label>
                                <select class="form-control" name="account_manager" id="account_manager" v-model="updatable_client_data.account_manager_id">
                                    <option v-for="user in users" :value="user.id">{{user.full_name}}</option>
                                </select>
                                <ul v-if="errors['account_manager_id']" class="error-list">
                                    <li v-for="error in errors['account_manager_id']">{{error}}</li>
                                </ul>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label" for="client_type">Client Type</label>
                                <select class="form-control" name="client_type" id="client_type" v-model="updatable_client_data.client_type_id">
                                    <option v-for="client_type in client_types" :value="client_type.id">{{client_type.name}}</option>
                                </select>
                                <ul v-if="errors['client_type_id']" class="error-list">
                                    <li v-for="error in errors['client_type_id']">{{error}}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-form-label" for="private_notes">Private Notes</label>
                                <editor v-model="updatable_client_data.private_notes" class="form-control" name="private_notes" id="private_notes" placeholder="Enter client notes"></editor>
                                <span class="caveat">Not seen by clients</span>
                                <ul v-if="errors['private_notes']" class="error-list">
                                    <li v-for="error in errors['private_notes']">{{error}}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <h2>Addresses</h2>
                    <draggable :list="existing_client.addresses" :animation="200" :tag="'ul'" class="list" v-if="existing_client.addresses.length > 0">
                        <li draggable="true" class="list-item" v-for="address in client.addresses">
                        <span class="row">
                            <span class="col-sm-11">
                                <i class="fal fa-arrows drag-icon icon"></i>
                                <span><strong>{{address.address_name}} - </strong>{{address.address_first_line}}, {{address.address_second_line}}, {{address.address_town}} {{address.address_county}} {{address.address_postcode}}</span>
                                <span v-if="address.is_primary_address === 1" class="list-highlighted-item"> - Primary Address</span>
                            </span>
                            <span class="col-sm-1 right-container">
                                <button class="btn btn-primary btn-sm" @click="editAddressClickHandler(address)">Edit</button>
                            </span>
                        </span>
                        </li>
                    </draggable>
                    <button class="btn primary-custom" @click="addAddressModalActive = true">Add New Address <i class="fal fa-plus"></i></button>
                </div>
                <div class="list-group-item">
                    <h2>Contacts</h2>
                    <div class="row row-eq-height">
                        <div v-for="contact in existing_client.contacts" class="col-sm-3">
                            <div class="card details-card mb-0">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                    <span class="d-inline-flex">
                                        <i title="contact.full_name" class="avatar-placeholder fal fa-user"></i>
                                    </span>
                                        <span class="d-inline-flex ml-3">{{contact.full_name}}</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p class="row"><i class="fal fa-envelope col-sm-2 text-center"></i> <span class="col-sm-10">{{contact.email}}</span></p>
                                    <p class="row"><i class="fas fa-mobile-alt col-sm-2 text-center"></i> <span class="col-sm-10">{{contact.mobile_number}}</span></p>
                                    <p class="row"><i class="fas fa-phone col-sm-2 text-center"></i> <span class="col-sm-10">{{contact.landline_tele}}</span></p>
                                    <button class="btn btn-primary mt-4" @click="editContactClickHandler(contact)">Edit</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <button class="card primary-custom align-content-center mb-0 h-100" @click="addClientContactModalActive = true">Add New Contact <i class="fal fa-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center">
            <button class="btn btn-primary" @click="updateClient(existing_client.id, updatable_client_data)">Save Changes</button>
        </div>
        <add-client-address-modal v-show="addAddressModalActive === true"
                           :client_id="client.id"
                           :what3words_api_key="what3words_api_key"
                           @address-added="clientUpdateHandler"
                           @add-address-modal-closed="addAddressModalActive = false">
        </add-client-address-modal>
        <edit-client-address-modal v-show="editAddressModalActive === true"
                            :address="selected_address"
                            :client_id="client.id"
                            :what3words_api_key="what3words_api_key"
                            @address-updated="clientUpdateHandler"
                            @edit-address-modal-closed="editAddressModalActive = false">
        </edit-client-address-modal>
        <add-client-contact-modal v-show="addClientContactModalActive === true"
                                   :client="client"
                                   @client-contact-added="clientUpdateHandler"
                                   @add-client-contact-modal-closed="addClientContactModalActive = false">
        </add-client-contact-modal>
        <edit-client-contact-modal v-show="editClientContactModalActive === true"
                                   :client_contact="selected_contact"
                                   @client-contact-updated="clientUpdateHandler"
                                   @edit-client-contact-modal-closed="editClientContactModalActive = false">
        </edit-client-contact-modal>
        <modal v-show="successModalActive === true"
               @close-modal="closeSuccessModal">
            <template slot="header">Success</template>
            <template slot="body">{{successBodyContent}}</template>
        </modal>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'
    import addClientAddressModal from '../../../../../../components/modals/address/client/add-client-address-modal'
    import editClientAddressModal from '../../../../../../components/modals/address/client/edit-client-address-modal'
    import modal from '../../../../../../components/modal'
    import addClientContactModal from '../../../../../../components/modals/client-contact/add-client-contact-modal'
    import editClientContactModal from '../../../../../../components/modals/client-contact/edit-client-contact-modal'
    import ClientHelper from '../../../../../../components/mixins/client-helper'
    import UserHelper from '../../../../../../components/mixins/user-helper'

    export default {
        name: "client-details",
        components : {
            draggable,
            addClientAddressModal,
            editClientAddressModal,
            editClientContactModal,
            addClientContactModal,
            modal
        },
        mixins: [ClientHelper, UserHelper],
        props: ['existing_client', 'what3words_api_key'],
        data() {
            return {
                updatable_client_data: {
                    name: this.existing_client.name,
                    landline_tele: this.existing_client.landline_tele,
                    mobile_number: this.existing_client.mobile_number,
                    website: this.existing_client.website,
                    company_colour: this.existing_client.company_colour,
                    private_notes: this.existing_client.private_notes,
                    client_type_id: this.existing_client.client_type_id,
                    account_manager_id: this.existing_client.account_manager_id
                },
                errors: {},
                selected_address: {},
                addAddressModalActive: false,
                editAddressModalActive: false,
                editClientContactModalActive: false,
                addClientContactModalActive: false,
                selected_contact: {},
                successModalActive: false,
                successBodyContent: ''
            }
        },
        mounted() {
            this.loadClientTypes();
            this.loadUsers();
        },
        computed: {
            formatted_aliases() {
                var aliases = [];

                this.existing_client.aliases.forEach(function(alias) {
                    aliases.push(alias.name);
                });

                return aliases.join(', ');
            }
        },
        methods: {
            clientUpdateHandler(message) {
                this.showSuccessModal(message);
                this.$eventHub.$emit('client-updated');
            },
            editAddressClickHandler(address) {
                this.selected_address = address;
                this.editAddressModalActive = true;
            },
            editContactClickHandler(contact) {
                this.selected_contact = contact;
                this.editClientContactModalActive = true;
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
