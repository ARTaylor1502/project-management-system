<template>
    <div class="list-group-item">
        <h2>Contacts</h2>
        <div class="row row-eq-height">
            <div v-for="contact in contacts" class="col-sm-3">
                <div class="card details-card mb-0">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                                    <span class="d-inline-flex">
                                        <i title="contact.full_name" class="avatar-placeholder fal fa-user"></i>
                                    </span>
                            <span class="d-inline-flex ml-3">{{contact.first_name}} {{contact.last_name}}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="row"><i class="fal fa-envelope col-sm-2 text-center"></i> <span class="col-sm-10">{{contact.email}}</span></p>
                        <p class="row"><i class="fas fa-mobile-alt col-sm-2 text-center"></i> <span class="col-sm-10">{{contact.mobile_number}}</span></p>
                        <p class="row"><i class="fas fa-phone col-sm-2 text-center"></i> <span class="col-sm-10">{{contact.landline_tele}}</span></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <button class="card primary-custom box-button align-content-center mb-0 h-100 w-100" @click="initAddClientContactModal">Add New Contact <i class="fal fa-plus"></i></button>
            </div>
        </div>
        <add-client-contact-modal ref="addClientContactModal"
                                  v-show="addClientContactModalActive === true"
                                  @client-contact-added="clientContactAddedHandler"
                                  @add-client-contact-modal-closed="addClientContactModalActive = false">
        </add-client-contact-modal>
    </div>
</template>

<script>
    import addClientContactModal from '../../../../../../components/modals/client-contact/add-client-contact-modal'

    export default {
        name: "client-contacts-step",
        components: {
            addClientContactModal
        },
        props: {
            errors: Object
        },
        data() {
            return {
                addClientContactModalActive: false,
                contacts: []
            }
        },
        methods: {
            initAddClientContactModal() {
                this.addClientContactModalActive = true;
                this.$refs.addClientContactModal.resetModalData();
            },
            clientContactAddedHandler(client) {
                this.contacts.push(client);
                this.$emit('client-contacts-step-complete', {
                    contacts: this.contacts,
                });
            }
        }
    }
</script>
