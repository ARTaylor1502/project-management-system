<template>
    <div class="list-group-item">
        <h2>Addresses</h2>
        <p v-if="!addresses.length > 0">No addresses currently assigned to user</p>
        <draggable :list="addresses" :animation="200" :tag="'ul'" class="list" v-show="addresses.length > 0">
            <li draggable="true" class="list-item" v-for="address in addresses">
                <span class="row">
                    <span class="col-sm-11">
                        <i class="fal fa-arrows drag-icon icon"></i>
                        <span>{{address.address_first_line}}, {{address.address_second_line}}, {{address.address_town}} {{address.address_county}} {{address.address_postcode}}</span>
                        <span v-if="address.is_primary_address === true" class="list-highlighted-item"> - Primary Address</span>
                    </span>
                    <span class="col-sm-1 right-container">

                    </span>
                </span>
            </li>
        </draggable>
        <button class="btn primary-custom" @click="initUserAddressModal">Add New Address <i class="fal fa-plus"></i></button>
        <add-user-address-modal ref="addUserAddressModal"
                                  v-show="addUserAddressModalActive"
                                  :what3words_api_key="what3words_api_key"
                                  @add-user-address-modal-closed="addUserAddressModalActive = false">
        </add-user-address-modal>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'
    import AddUserAddressModal from '../../../../../../components/modals/address/user/add-user-address-modal'

    export default {
        name: "addresses-step",
        components: {
            AddUserAddressModal,
            draggable
        },
        props: {
            errors: Object,
            what3words_api_key: String
        },
        created() {
            this.$eventHub.$on('proposed-user-address-added', this.userAddressUpdateHandler);
        },
        data() {
            return {
                addresses : [],
                addUserAddressModalActive: false
            }
        },
        methods: {
            initUserAddressModal() {
                this.addUserAddressModalActive = true;
                this.$refs.addUserAddressModal.resetModalData();
            },
            userAddressUpdateHandler(address) {
                this.addUserAddressModalActive = false;
                this.addresses.push(address);
                this.$emit('addresses-step-complete', {
                    addresses: this.addresses,
                });
            }
        }
    }
</script>
