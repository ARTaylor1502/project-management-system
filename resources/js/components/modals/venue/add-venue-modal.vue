<template>
    <modal @close-modal="closeModal">
        <template slot="header">
            Add New Venue
        </template>
        <template slot="body">
            <form @submit.prevent="addVenue">
                <div class="form-group">
                    <label class="col-form-label" for="name">Venue Name</label>
                    <input class="form-control" id="name" placeholder="Venue Name" name="name" type="text" v-model="formData['name']">
                    <ul v-if="errors['name']" class="error-list">
                        <li v-for="error in errors['name']">{{error}}</li>
                    </ul>
                </div>
                <div class="form-group autocomplete">
                    <label class="col-form-label" for="address_postcode">Venue Postcode</label>
                    <div class="input-group mb-3">
                        <input class="form-control" type="text" id="address_postcode" placeholder="Enter a postcode" name="address_postcode" v-model="formData['address_postcode']"/>
                        <div v-if="addresses_window_opened" class="options">
                            <div class="options-container">
                                <div v-for="address in addresses" class="option" @click="selectAddressHandler(address)">{{address.line_1}}, {{address.town}}</div>
                            </div>
                        </div>
                        <div class="input-group-append">
                            <span id="postcode_lookup" @click="searchAddresses" class="input-group-text cta">Lookup</span>
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
                       <input class="form-control" type="text" id="address_first_line" name="address_first_line" v-model="formData['address_first_line']"/>
                        <ul v-if="errors['address_first_line']" class="error-list">
                            <li v-for="error in errors['address_first_line']">{{error}}</li>
                        </ul>
                   </div>
                   <div class="form-group">
                       <label class="col-form-label" for="address_second_line">Address Second Line</label>
                       <input class="form-control" type="text" id="address_second_line" name="address_second_line" v-model="formData['address_second_line']"/>
                       <ul v-if="errors['address_second_line']" class="error-list">
                           <li v-for="error in errors['address_second_line']">{{error}}</li>
                       </ul>
                   </div>
                   <div class="form-group">
                       <label class="col-form-label" for="address_town">Town</label>
                       <input class="form-control" type="text" id="address_town" name="address_town" v-model="formData['address_town']"/>
                       <ul v-if="errors['address_town']" class="error-list">
                           <li v-for="error in errors['address_town']">{{error}}</li>
                       </ul>
                   </div>
                   <div class="form-group">
                       <label class="col-form-label" for="address_county">County</label>
                       <input class="form-control" type="text" id="address_county" name="address_county" v-model="formData['address_county']"/>
                       <ul v-if="errors['address_county']" class="error-list">
                           <li v-for="error in errors['address_county']">{{error}}</li>
                       </ul>
                   </div>
                   <div class="form-group">
                       <label class="col-form-label" for="what3words_code">What3Words Code</label>
                       <input class="form-control" type="text" id="what3words_code" name="what3words_code" v-model="formData['what3words_code']"/>
                       <ul v-if="errors['what3words_code']" class="error-list">
                           <li v-for="error in errors['what3words_code']">{{error}}</li>
                       </ul>
                   </div>
                    <div class="form-group">
                        <label class="col-form-label" for="add_accommodation_landline_tele">Landline Telephone</label>
                        <input class="form-control" type="text" id="add_accommodation_landline_tele" name="add_accommodation_landline_tele" v-model="formData['landline_tele']"/>
                        <ul v-if="errors['landline_tele']" class="error-list">
                            <li v-for="error in errors['landline_tele']">{{error}}</li>
                        </ul>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="add_accommodation_category_id">Car Park Type</label>
                        <select id="add_accommodation_category_id" class="form-control" v-model="formData['car_park_type_id']">
                            <option v-for="category in car_park_types" name="category_id" :value="category.id">{{category.name}}</option>
                        </select>
                        <ul v-if="errors['category_id']" class="error-list">
                            <li v-for="error in errors['category_id']">{{error}}</li>
                        </ul>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Add</button>
            </form>
        </template>
    </modal>
</template>

<script>
    import modal from '../../modal'

    export default {
        name: "add-venue-modal",
        components: {
            modal
        },
        data() {
            return {
                errors: {},
                formData: {
                    name: null,
                    address_postcode: null,
                    address_first_line: null,
                    address_second_line: null,
                    address_town: null,
                    address_county: null,
                    what3words_code: null,
                    landline_tele: null,
                    car_park_type_id: null
                },
                addresses: [],
                car_park_types: [],
                address_longitude: '',
                address_latitude: '',
                addressPopulated: false,
                addresses_window_opened: false
            }
        },
        created() {
            this.loadCarParkTypes();
        },
        methods: {
            addVenue() {
                let self = this;

                axios.post(this.$route('api.venue.store'), self.formData)
                .then(response => {
                    if(response.data.status === 'success') {
                        self.resetForm();
                        self.closeModal();
                        self.$emit('venue-added', response.data.message);
                    } else if(response.data.status === 'error') {
                        self.errors = response.data.errors;
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            },
            resetForm() {
                for (let prop in this.formData) {
                    if (this.formData.hasOwnProperty(prop)) {
                        this.formData[prop] = null;
                    }
                }

                this.addressPopulated = false;
            },
            searchAddresses() {
                axios.get(this.$route('api.address.lookup', this.formData.address_postcode))
                .then(response => {
                    this.addresses = [];

                    response.data.addresses.forEach((address) => {
                        this.addresses.push(address);
                    });
                    this.addresses_window_opened = true;
                    this.address_longitude = response.data.lng;
                    this.address_latitude = response.data.lat;
                }).catch(function (error) {
                    if(error.response) {
                        self.errors = error.response.data.errors;
                    }
                });
            },
            loadCarParkTypes() {
                axios.get(this.$route('api.venue.car.park.types'))
                .then(response => {
                    this.car_park_types = [];

                    response.data.forEach((car_park_type) => {
                        this.car_park_types.push(car_park_type);
                    });

                    if(this.car_park_types.length > 0) {
                        this.formData.car_park_type_id = this.car_park_types[0].id;
                    }

                }).catch(function (error) {
                    if(error.response) {
                        this.errors = error.response.data.errors;
                    }
                });
            },
            selectAddressHandler(address) {
                this.populateFormAddress(address);
                this.getWhat3WordsCode(this.address_latitude, this.address_longitude);
                this.addressPopulated = true;
                this.addresses_window_opened = false;
            },
            populateFormAddress(address) {
                this.formData.address_first_line = address.line_1;
                this.formData.address_second_line = address.line_2;
                this.formData.address_town = address.town;
                this.formData.address_county = address.county;
            },
            getWhat3WordsCode(latitude, longitude) {
                let self = this;

                what3words.api.convertTo3wa({lat:latitude, lng:longitude}).then(function(response) {
                    self.formData.what3words_code = response.words;
                });
            },
            closeModal() {
                this.$emit('venue-modal-closed');
            }
        }
    }
</script>
