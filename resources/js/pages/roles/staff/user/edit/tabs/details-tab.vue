<template>
    <div>
        <div v-if="user_updated" class="alert alert-success mb-0">
            <i class="fas fa-times cursor-pointer float-right" @click="user_updated = false"></i>
            User successfully updated
        </div>
        <div v-if="existing_user" class="card list-group shadow">
            <div class="list-group-item">
                <h2>Name</h2>
                <div class="row">
                    <div class="col-md-6">
                        <label class="col-form-label" for="title">Title</label>
                        <select class="form-control" name="title" id="title" v-model="updatable_user_data.title_id">
                            <option v-for="title in titles" :value="title.id">{{title.name}}</option>
                        </select>
                        <ul v-if="errors['title_id']" class="error-list">
                            <li v-for="error in errors['title_id']">{{error}}</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label" for="role">Role</label>
                        <select class="form-control" name="role" id="role" v-model="updatable_user_data.role_id">
                            <option v-for="role in roles" :value="role.id">{{role.name}}</option>
                        </select>
                        <ul v-if="errors['role_id']" class="error-list">
                            <li v-for="error in errors['role_id']">{{error}}</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label" for="first_name">First Name</label>
                        <input v-model="updatable_user_data.first_name" class="form-control" id="first_name" name="first_name" type="text">
                        <ul v-if="errors['first_name']" class="error-list">
                            <li v-for="error in errors['first_name']">{{error}}</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label" for="last_name">Last Name</label>
                        <input v-model="updatable_user_data.last_name" class="form-control" id="last_name" name="last_name" type="text">
                        <ul v-if="errors['last_name']" class="error-list">
                            <li v-for="error in errors['last_name']">{{error}}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="list-group-item">
                <h2>Contact Details</h2>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="col-form-label" for="email">Email</label>
                        <input v-model="existing_user.email" class="form-control" id="email" name="email" type="email" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="col-form-label" for="mobile_tele">Mobile</label>
                        <input v-model="updatable_user_data.mobile_tele" class="form-control" id="mobile_tele" name="mobile_tele" type="tel">
                        <ul v-if="errors['mobile_tele']" class="error-list">
                            <li v-for="error in errors['mobile_tele']">{{error}}</li>
                        </ul>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="col-form-label" for="landline_tele">Landline</label>
                        <input v-model="updatable_user_data.landline_tele" class="form-control" id="landline_tele" name="landline_tele" type="tel">
                        <ul v-if="errors['landline_tele']" class="error-list">
                            <li v-for="error in errors['landline_tele']">{{error}}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="list-group-item">
                <h2>Addresses</h2>
                <draggable :list="existing_user.addresses" :animation="200" :tag="'ul'" class="list" v-if="existing_user.addresses.length > 0">
                    <li draggable="true" class="list-item" v-for="address in existing_user.addresses">
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
            <add-user-address-modal v-show="addAddressModalActive === true"
                               :user_id="existing_user.id"
                               :what3words_api_key="what3words_api_key"
                               @add-user-address-modal-closed="addAddressModalActive = false">
            </add-user-address-modal>
            <edit-user-address-modal v-show="editAddressModalActive === true"
                                :existing_address="selected_address"
                                :user_id="existing_user.id"
                                :what3words_api_key="what3words_api_key"
                                @edit-user-address-modal-closed="editAddressModalActive = false">
            </edit-user-address-modal>
            <modal v-show="successModalActive === true"
                   @close-modal="closeSuccessModal">
                <template slot="header">Success</template>
                <template slot="body">{{successBodyContent}}</template>
            </modal>
        </div>
        <div class="text-center">
            <button @click="updateUser(existing_user.id, updatable_user_data)" class="btn btn-primary">Save Changes</button>
        </div>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'
    import addUserAddressModal from '../../../../../../components/modals/address/user/add-user-address-modal'
    import editUserAddressModal from '../../../../../../components/modals/address/user/edit-user-address-modal'
    import modal from '../../../../../../components/modal'
    import UserHelper from '../../../../../../components/mixins/user-helper'

    export default {
        name: "details-tab",
        components: {
            draggable,
            addUserAddressModal,
            editUserAddressModal,
            modal
        },
        mixins: [UserHelper],
        props: {
            existing_user: Object,
            what3words_api_key: String
        },
        data() {
            return {
                errors: {},
                addAddressModalActive: false,
                editAddressModalActive: false,
                successModalActive: false,
                successBodyContent: '',
                selected_address: false,
                user_updated: false,
                updatable_user_data: {
                    first_name: this.existing_user.first_name,
                    last_name: this.existing_user.last_name,
                    landline_tele: this.existing_user.landline_tele,
                    mobile_tele: this.existing_user.mobile_tele,
                    title_id: this.existing_user.title.id,
                    role_id: this.existing_user.role.id
                }
            }
        },
        created() {
            this.loadTitles();
            this.loadRoles();
            this.$eventHub.$on('user-updated', this.userUpdateHandler);
            this.$eventHub.$on('user-update-errors', this.userUpdateErrorHandler);
            this.$eventHub.$on('user-address-added', this.showSuccessModal);
            this.$eventHub.$on('user-address-updated', this.showSuccessModal);
        },
        methods: {
            editAddressClickHandler(address) {
                this.selected_address = address;
                this.editAddressModalActive = true;
            },
            userUpdateHandler() {
                this.errors = [];
                this.user_updated = true;
                this.$emit('reload-user');
            },
            userUpdateErrorHandler(errors) {
                this.errors = errors;
            },
            showSuccessModal(message) {
                this.successBodyContent = message;
                this.successModalActive = true;
                this.$eventHub.$emit('reload-user');
            },
            closeSuccessModal() {
                this.successModalActive = false;
            }
        }
    }
</script>
