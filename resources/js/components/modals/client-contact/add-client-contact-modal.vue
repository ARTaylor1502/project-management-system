<template>
    <modal @close-modal="closeModal">
        <template slot="header">
            Add New Client Contact
        </template>
        <template slot="body">
            <form @submit.prevent="addClientContact">
                <div class="form-group">
                    <label class="col-form-label" for="first_name">First Name</label>
                    <input class="form-control" id="first_name" name="first_name" type="text" v-model="client['first_name']">
                    <ul v-if="errors['first_name']" class="error-list">
                        <li v-for="error in errors['first_name']">{{error}}</li>
                    </ul>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="last_name">Last Name</label>
                    <input class="form-control" type="text" id="last_name" name="last_name" v-model="client['last_name']"/>
                    <ul v-if="errors['last_name']" class="error-list">
                        <li v-for="error in errors['last_name']">{{error}}</li>
                    </ul>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="email">Email</label>
                    <input class="form-control" type="email" id="email" name="email" v-model="client['email']"/>
                    <ul v-if="errors['email']" class="error-list">
                        <li v-for="error in errors['email']">{{error}}</li>
                    </ul>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="is_primary_contact">Is Primary Contact?</label>
                    <input type="checkbox" id="is_primary_contact" name="is_primary_contact" v-model="client['is_primary_contact']"/>
                    <ul v-if="errors['is_primary_contact']" class="error-list">
                        <li v-for="error in errors['is_primary_contact']">{{error}}</li>
                    </ul>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="landline_tele">Landline Telephone</label>
                    <input class="form-control" type="text" id="landline_tele" name="landline_tele" v-model="client['landline_tele']"/>
                    <ul v-if="errors['landline_tele']" class="error-list">
                        <li v-for="error in errors['landline_tele']">{{error}}</li>
                    </ul>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="mobile_number">Mobile Number</label>
                    <input class="form-control" type="text" id="mobile_number" name="mobile_number" v-model="client['mobile_number']"/>
                    <ul v-if="errors['mobile_number']" class="error-list">
                        <li v-for="error in errors['mobile_number']">{{error}}</li>
                    </ul>
                </div>

                <button type="submit" class="btn btn-primary">Add</button>
            </form>
        </template>
    </modal>
</template>

<script>
    import modal from '../../modal'

    export default {
        name: "add-client-contact-modal",
        components: {
            modal
        },
        data() {
            return resetData();
        },
        methods: {
            resetModalData() {
                Object.assign(this.$data, resetData());
            },
            addClientContact() {
                this.closeModal();
                this.$emit('client-contact-added', this.client);
            },
            closeModal() {
                this.$emit('add-client-contact-modal-closed');
            }
        }
    }

    function resetData() {
        return {
            errors: {},
            client: {
                first_name: '',
                last_name: '',
                email: '',
                is_primary_contact: false,
                landline_tele: '',
                mobile_number: ''
            },
        }
    }
</script>
