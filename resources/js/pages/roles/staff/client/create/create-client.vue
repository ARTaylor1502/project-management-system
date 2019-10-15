<template>
    <div>
        <div class="list-group shadow">
            <name-step id="name_step" :errors="errors" @name-step-complete="handler($event, 2)" @name-step-incomplete="setStepNumber(1)"></name-step>
            <transition name="fade" mode="out-in">
                <contact-details-step v-show="current_step > 1" id="details_step" :errors="errors" @contact-details-step-complete="handler($event, 3)" @contact-details-step-incomplete="setStepNumber(2)"></contact-details-step>
            </transition>
            <transition name="fade" mode="out-in">
                <branding-step id="branding_step" v-show="current_step > 2" :errors="errors" @branding-step-complete="handler($event, 4)" @branding-step-incomplete="setStepNumber(3)"></branding-step>
            </transition>
            <transition name="fade" mode="out-in">
                <addresses-step id="addresses_step" v-show="current_step > 3" :errors="errors" :what3words_api_key="what3words_api_key" @addresses-step-complete="handler($event, 5)" @addresses-step-incomplete="setStepNumber(4)"></addresses-step>
            </transition>
            <transition name="fade" mode="out-in">
                <client-contacts-step id="client_contact_step" v-show="current_step > 4" :errors="errors" @client-contacts-step-complete="handler($event, 6)" @client-contacts-step-incomplete="setStepNumber(5)"></client-contacts-step>
            </transition>
            <transition name="fade" mode="out-in">
                <notes-step id="notes_step" :errors="errors" v-show="current_step > 5" @notes-step-complete="handler($event, 7)" @notes-step-incomplete="setStepNumber(6)"></notes-step>
            </transition>
        </div>
        <button v-if="current_step === 7" class="btn btn-primary btn-lg float-right mb-5" @click="addClientHandler">Add Client</button>
    </div>
</template>

<script>
    import NameStep from './steps/name-step';
    import ContactDetailsStep from './steps/contact-details-step';
    import AddressesStep from './steps/addresses-step';
    import BrandingStep from './steps/branding-step';
    import ClientContactsStep from './steps/contacts-step';
    import NotesStep from './steps/notes-step';
    import ClientHelper from '../../../../../components/mixins/client-helper'

    export default {
        name: "create-client",
        props: ['what3words_api_key'],
        components: {
            NameStep,
            ContactDetailsStep,
            AddressesStep,
            BrandingStep,
            ClientContactsStep,
            NotesStep
        },
        mixins: [ClientHelper],
        data() {
            return {
                errors: {},
                current_step: 1,
                client_data: {},
                formData: null
            }
        },
        created() {
            this.$eventHub.$on('new-client-added', this.clientAddedHandler);
            this.$eventHub.$on('new-client-added-errors', this.clientAddedErrorsHandler);
        },
        methods: {
            addClientHandler() {
                this.populateForm();
                this.addClient(this.formData);
            },
            populateForm() {
                this.formData = new FormData();

                this.formData.append('name', this.client_data.name);
                this.formData.append('client_type_id', this.client_data.client_type.id);
                this.formData.append('account_manager_id', this.client_data.account_manager_id);
                this.formData.append('landline_tele', this.client_data.landline_tele);
                this.formData.append('mobile_number', this.client_data.mobile_number);
                this.formData.append('company_colour', this.client_data.company_colour);
                this.formData.append('private_notes', this.client_data.private_notes);
                this.formData.append('website', this.client_data.website);

                if(this.client_data.contacts) {
                    for(let i = 0; i < this.client_data.contacts.length; i++){
                        let contact = this.client_data.contacts[i];
                        this.formData.append('contacts[' + i + ']', JSON.stringify(contact));
                    }
                }

                if(this.client_data.addresses) {
                    for(let i = 0; i < this.client_data.addresses.length; i++){
                        let address = this.client_data.addresses[i];
                        this.formData.append('addresses[' + i + ']', JSON.stringify(address));
                    }
                }

                if(this.client_data.file && this.client_data.file.length > 0) {
                    let file = this.client_data.file[0];
                    this.formData.append('logo', file);
                }
            },
            clientAddedHandler(new_client_id) {
                window.location.href = '/staff/clients/client/' + new_client_id;
            },
            clientAddedErrorsHandler(errors) {
                this.errors = errors;
            },
            updateClientData(event) {
                for (const [key, value] of Object.entries(event)) {
                    this.client_data[key] = value;
                }
            },
            setStepNumber(step_number) {
                if(step_number > this.current_step) {
                    this.current_step = step_number;
                }
            },
            handler(e, step_number) {
                this.updateClientData(e);
                this.setStepNumber(step_number);
            }
        }
    }
</script>
