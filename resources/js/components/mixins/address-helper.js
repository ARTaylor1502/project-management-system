export default {
    data() {
        return {
            addresses: [],
            address_longitude: '',
            address_latitude: ''
        }
    },
    methods: {
        searchAddresses(postcode) {
            let self = this;

            this.resetAddresses();

            axios.get(this.$route('api.address.lookup', postcode.replace(' ', '')))
            .then(response => {
                response.data.addresses.forEach((address) => {
                    self.addresses.push(address);
                });

                self.address_longitude = response.data.lng;
                self.address_latitude = response.data.lat;
                self.$eventHub.$emit('postcode-addresses-search-results');
            })
            .catch(function (error) {
                if(error.response) {
                    self.$eventHub.$emit('postcode-addresses-search-errors', error.response.data.errors);
                }
            });
        },
        addUserAddress(user_id, address_data) {
            let self = this;

            axios.post(this.$route('api.user.store.address', user_id), address_data)
                .then(response => {
                    if(response.data.status === 'success') {
                        self.$eventHub.$emit('user-address-added', response.data.message);
                    } else if(response.data.status === 'error') {
                        self.errors = response.data.errors;
                    }
                }).catch(function (error) {
                console.log(error);
            });
        },
        addClientAddress(client_id, address_data) {
            let self = this;

            axios.post(this.$route('api.client.store.address', client_id), address_data)
            .then(response => {
                if(response.data.status === 'success') {
                    self.$eventHub.$emit('client-address-added', response.data.message);
                } else if(response.data.status === 'error') {
                    self.errors = response.data.errors;
                }
            }).catch(function (error) {
                console.log(error);
            });
        },
        updateUserAddress(user_id, address_id, address_data) {
            let self = this;

            axios.put(this.$route('api.user.update.address', user_id, address_id), address_data)
            .then(response => {
                if(response.data.status === 'success') {
                    self.$eventHub.$emit('user-address-updated', response.data.message);
                } else if(response.data.status === 'error') {
                    self.errors = response.data.errors;
                }
            }).catch(function (error) {
                console.log(error);
            });
        },
        updateClientAddress(client_id, address_id, address_data) {
            let self = this;

            axios.put(this.$route('api.client.update.address', client_id, address_id), address_data)
            .then(response => {
                if(response.data.status === 'success') {
                    self.$eventHub.$emit('client-address-updated', response.data.message);
                } else if(response.data.status === 'error') {
                    self.errors = response.data.errors;
                }
            }).catch(function (error) {
                console.log(error);
            });
        },
        resetAddresses() {
            this.addresses = [];
        }
    }
}
