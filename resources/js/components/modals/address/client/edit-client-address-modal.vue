<template>
    <modal @close-modal="closeModal">
        <template slot="header">Update Client Address</template>
        <template slot="body">
            <form v-if="existing_address" @submit.prevent="updateClientAddress(client_id, existing_address.id, existing_address)">
                <div class="form-group">
                    <label class="col-form-label" for="address_first_line">Address First Line</label>
                    <input class="form-control" type="text" id="address_first_line" name="address_first_line" v-model="existing_address.address_first_line"/>
                    <ul v-if="errors['address_first_line']" class="error-list">
                        <li v-for="error in errors['address_first_line']">{{error}}</li>
                    </ul>
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="address_second_line">Address Second Line</label>
                    <input class="form-control" type="text" id="address_second_line" name="address_second_line" v-model="existing_address.address_second_line"/>
                    <ul v-if="errors['address_second_line']" class="error-list">
                        <li v-for="error in errors['address_second_line']">{{error}}</li>
                    </ul>
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="address_town">Town</label>
                    <input class="form-control" type="text" id="address_town" name="address_town" v-model="existing_address.address_town"/>
                    <ul v-if="errors['address_town']" class="error-list">
                        <li v-for="error in errors['address_town']">{{error}}</li>
                    </ul>
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="address_county">County</label>
                    <input class="form-control" type="text" id="address_county" name="address_county" v-model="existing_address.address_county"/>
                    <ul v-if="errors['address_county']" class="error-list">
                        <li v-for="error in errors['address_county']">{{error}}</li>
                    </ul>
                </div>
                <div class="form-group autocomplete">
                    <label class="col-form-label" for="address_postcode">Postcode</label>
                    <input class="form-control" type="text" id="address_postcode" placeholder="Enter a postcode" name="address_postcode" v-model="existing_address.address_postcode"/>
                    <ul v-if="errors['address_postcode']"  class="error-list">
                        <li v-for="error in errors['address_postcode']">{{error}}</li>
                    </ul>
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="what3words_code">What3Words Code</label>
                    <input class="form-control" type="text" id="what3words_code" name="what3words_code" v-model="existing_address.what3words_code"/>
                    <ul v-if="errors['what3words_code']" class="error-list">
                        <li v-for="error in errors['what3words_code']">{{error}}</li>
                    </ul>
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="is_primary_address">Primary Address?</label>
                    <input type="checkbox" id="is_primary_address" name="is_primary_address" v-model="existing_address.is_primary_address"/>
                    <ul v-if="errors['is_primary_address']" class="error-list">
                        <li v-for="error in errors['is_primary_address']">{{error}}</li>
                    </ul>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </template>
    </modal>
</template>

<script>
    import modal from '../../../modal'
    import AddressHelper from '../../../../components/mixins/address-helper'

    export default {
        name: "edit-client-address-modal",
        components: {
            modal
        },
        props: ['existing_address', 'client_id'],
        mixins: [AddressHelper],
        data() {
            return {
                errors: {}
            }
        },
        methods: {
            closeModal() {
                this.$emit('edit-client-address-modal-closed');
            }
        }
    }
</script>

<style scoped>

</style>
