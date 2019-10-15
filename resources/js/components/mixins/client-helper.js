export default {
    data() {
        return {
            clients: [],
            client: false,
            client_types: [],
            client_contacts: []
        }
    },
    methods: {
        loadClient(client_id) {
            let self = this;

            axios.get(this.$route('api.client.single', client_id))
            .then(response => {
                self.client = response.data;
            }).catch(function (error) {
                console.log(error);
            });
        },
        loadClients(filters) {
            let self = this, url = '/api/client';

            if(filters !== undefined) {
                let count = 0;

                for (var key in filters) {
                    if (filters.hasOwnProperty(key)) {
                        if(count === 0) {
                            url += '?';
                        } else {
                            url += '&';
                        }

                        url += key + '=' + filters[key];
                        count++;
                    }
                }
            }

            axios.get(url)
            .then(response => {
                self.resetClients();

                if(response.data.data) {
                    response.data.data.forEach(function(client) {
                        self.clients.push(client);
                    });

                    self.$eventHub.$emit('client-pagination-updated', {number_of_pages: response.data.last_page, page_number: response.data.current_page, total_items_count: response.data.total});
                } else {
                    response.data.forEach(function(client) {
                        self.clients.push(client);
                    });
                }

                }).catch(function (error) {
                console.log(error);
            });
        },
        addClient(client_data) {
            let self = this;

            axios.post(this.$route('api.client.store'), client_data, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                if(response.data.status === 'success') {
                    self.$eventHub.$emit('new-client-added', response.data.message);
                } else if(response.data.status === 'error') {
                    self.$eventHub.$emit('new-client-added-errors', response.data.errors);
                }
            }).catch(function (error) {
                console.log(error);
            });
        },
        updateClient(client_id, client_data) {
            let self = this;

            axios.put(this.$route('api.client.update', client_id), client_data)
            .then(response => {
                if(response.data.status === 'success') {
                    console.log(response.data);
                } else if(response.data.status === 'error') {
                    self.errors = response.data.errors;
                }
            }).catch(function (error) {
                console.log(error);
            });
        },
        addClientPassword(client_id, client_password_data) {
            let self = this;

            axios.post(this.$route('api.client.store.password', client_id), client_password_data)
            .then(response => {
                if(response.data.status === 'success') {
                    self.$eventHub.$emit('client-password-added', response.data.message);
                } else if(response.data.status === 'error') {
                    console.log(response.data.errors);
                }
            }).catch(function (error) {
                console.log(error);
            });
        },
        deletePassword(password_id) {
            let self = this;

            axios.post(this.$route('api.client.delete.password'), {password_id : password_id})
            .then(response => {
                if(response.data.status === 'success') {
                    self.$eventHub.$emit('client-password-deleted', response.data.message);
                } else if(response.data.status === 'error') {
                    console.log(response.data.errors);
                }
                self.client = response.data;
            }).catch(function (error) {
                console.log(error);
            });
        },
        loadClientTypes() {
            let self = this;

            axios.get(this.$route('api.client.types'))
            .then(response => {
                response.data.forEach(function(client_type) {
                    self.client_types.push(client_type);
                });
            }).catch(function (error) {
                console.log(error);
            });
        },
        loadClientContacts(client_id) {
            this.client_contacts = [];

            axios.get(this.$route('api.client.contacts', client_id))
            .then(response => {
                response.data.forEach((contact) => {
                    /*if(contact.is_primary_contact) {
                        contact.primary_contact_label = '(Primary Contact)';
                    } else {
                        contact.primary_contact_label = '';
                    }*/
                    this.client_contacts.push(contact);
                });
                /*this.client_contact = {};
                this.client_contact_label = 'Select a Client Contact...';
                this.infoChanged();*/
            }).catch(function (error) {
                console.log(error);
            });
        },
        resetClients() {
            this.clients = [];
        }
    }
}
