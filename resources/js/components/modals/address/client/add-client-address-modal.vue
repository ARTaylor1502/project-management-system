<template>
    <modal @close-modal="closeModal">
        <template slot="header">Add New Client Address</template>
        <template slot="body">
            <form @submit.prevent="addClientAddressHandler">
                <div class="form-group">
                    <label class="col-form-label" for="address_name">Name</label>
                    <input class="form-control" type="text" id="address_name" name="address_name" v-model="address.address_name"/>
                    <ul v-if="errors['address_name']" class="error-list">
                        <li v-for="error in errors['address_name']">{{error}}</li>
                    </ul>
                </div>
                <div class="form-group autocomplete">
                    <label class="col-form-label" for="address_postcode">Postcode</label>
                    <div class="input-group mb-3">
                        <input class="form-control" type="text" id="address_postcode" placeholder="Enter a postcode" name="address_postcode" v-model="address.address_postcode"/>
                        <div v-if="addresses_window_opened" class="options">
                            <div class="options-container">
                                <div v-for="a in addresses" class="option" @click="selectAddressHandler(a)">{{a.line_1}}, {{a.town}}</div>
                            </div>
                        </div>
                        <div class="input-group-append">
                            <span id="postcode_lookup" @click="searchAddresses(address.address_postcode)" class="input-group-text cta">Lookup</span>
                        </div>
                        <span class="caveat">Enter a postcode and click Lookup to view and select from a list of matching addresses</span>
                    </div>
                    <ul v-if="errors['address_postcode']"  class="error-list">
                        <li v-for="error in errors['address_postcode']">{{error}}</li>
                    </ul>
                </div>
                <div v-show="addressPopulated === true">
                    <div class="form-group">
                        <label class="col-form-label" for="address_first_line">Address First Line</label>
                        <input class="form-control" type="text" id="address_first_line" name="address_first_line" v-model="address.address_first_line"/>
                        <ul v-if="errors['address_first_line']" class="error-list">
                            <li v-for="error in errors['address_first_line']">{{error}}</li>
                        </ul>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="address_second_line">Address Second Line</label>
                        <input class="form-control" type="text" id="address_second_line" name="address_second_line" v-model="address.address_second_line"/>
                        <ul v-if="errors['address_second_line']" class="error-list">
                            <li v-for="error in errors['address_second_line']">{{error}}</li>
                        </ul>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="address_town">Town</label>
                        <input class="form-control" type="text" id="address_town" name="address_town" v-model="address.address_town"/>
                        <ul v-if="errors['address_town']" class="error-list">
                            <li v-for="error in errors['address_town']">{{error}}</li>
                        </ul>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="address_county">County</label>
                        <input class="form-control" type="text" id="address_county" name="address_county" v-model="address.address_county"/>
                        <ul v-if="errors['address_county']" class="error-list">
                            <li v-for="error in errors['address_county']">{{error}}</li>
                        </ul>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="what3words_code">What3Words Code</label>
                        <input class="form-control" type="text" id="what3words_code" name="what3words_code" v-model="address.what3words_code"/>
                        <ul v-if="errors['what3words_code']" class="error-list">
                            <li v-for="error in errors['what3words_code']">{{error}}</li>
                        </ul>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="is_primary_address">Primary Address?</label>
                        <input type="checkbox" id="is_primary_address" name="is_primary_address" v-model="address.is_primary_address"/>
                        <ul v-if="errors['is_primary_address']" class="error-list">
                            <li v-for="error in errors['is_primary_address']">{{error}}</li>
                        </ul>
                    </div>
                </div>
                <button v-if="addressPopulated" type="submit" class="btn btn-primary">Add</button>
            </form>
        </template>
    </modal>
</template>

<script>
    import modal from '../../../modal'
    import AddressHelper from '../../../../components/mixins/address-helper'

    export default {
        name: "add-client-address-modal",
        components: {
            modal
        },
        props: {
            client_id: {
                type: Number,
                required: false
            },
            what3words_api_key: {
                type: String,
                required: true
            }
        },
        mixins: [AddressHelper],
        data() {
            return resetData();
        },
        mounted() {
            let what3words_script = document.createElement('script');
            what3words_script.setAttribute('src', 'https://assets.what3words.com/sdk/v3/what3words.js?key=' + this.what3words_api_key)
            document.head.appendChild(what3words_script)
        },
        created() {
            this.$eventHub.$on('postcode-addresses-search-results', this.postcodeSearchResultsHandler);
        },
        methods: {
            resetModalData: function (){
                Object.assign(this.$data, resetData());
            },
            addClientAddressHandler() {
                if(this.client_id) {
                    this.addClientAddress(this.client_id, this.address);
                } else {
                    this.$eventHub.$emit('proposed-client-address-added', this.address);
                }
            },
            selectAddressHandler(address) {
                this.populateFormAddress(address);
                this.getWhat3WordsCode(this.address_latitude, this.address_longitude);
                this.addressPopulated = true;
                this.addresses_window_opened = false;
            },
            postcodeSearchResultsHandler() {
                this.addresses_window_opened = true;
            },
            populateFormAddress(address) {
                this.address.address_first_line = address.line_1;
                this.address.address_second_line = address.line_2;
                this.address.address_town = address.town;
                this.address.address_county = address.county;
            },
            getWhat3WordsCode(latitude, longitude) {
                let self = this;
                what3words.api.convertTo3wa({lat:latitude, lng:longitude}).then(function(response) {
                    self.address.what3words_code = response.words;
                });
            },
            closeModal() {
                this.$emit('add-client-address-modal-closed');
            }
        }
    }

    function resetData() {
        return {
            errors: {},
            address: {
                is_primary_address: false,
                address_name: '',
                address_postcode: '',
                address_first_line: '',
                address_second_line: '',
                address_town: '',
                address_county: '',
                what3words_code: ''
            },
            addresses: [],
            address_longitude: '',
            address_latitude: '',
            addressPopulated: false,
            addresses_window_opened: false
        }
    }
</script>
