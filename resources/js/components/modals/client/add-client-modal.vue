<template>
    <modal @close-modal="closeModal">
        <template slot="header">Add New Client</template>
        <template slot="body">
            <form @submit.prevent="addClient(formData)">
                <div class="form-group">
                    <label class="col-form-label" for="name">Name of Client</label>
                    <input class="form-control" id="name" name="name" type="text" v-model="formData['name']">
                    <ul v-if="errors['name']" class="error-list">
                        <li v-for="error in errors['name']">{{error}}</li>
                    </ul>
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="landline_tele">Landline Telephone</label>
                    <input class="form-control" type="text" id="landline_tele" name="landline_tele" v-model="formData['landline_tele']"/>
                    <ul v-if="errors['landline_tele']" class="error-list">
                        <li v-for="error in errors['landline_tele']">{{error}}</li>
                    </ul>
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="mobile_number">Mobile Number</label>
                    <input class="form-control" type="text" id="mobile_number" name="mobile_number" v-model="formData['mobile_number']"/>
                    <ul v-if="errors['mobile_number']" class="error-list">
                        <li v-for="error in errors['mobile_number']">{{error}}</li>
                    </ul>
                </div>
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
                    <label class="col-form-label" for="address_postcode">Postcode</label>
                    <input class="form-control" type="text" id="address_postcode" name="address_postcode" v-model="formData['address_postcode']"/>
                    <ul v-if="errors['address_postcode']" class="error-list">
                        <li v-for="error in errors['address_postcode']">{{error}}</li>
                    </ul>
                </div>
                <button type="submit" class="btn btn-primary">Add</button>
            </form>
        </template>
    </modal>
</template>

<script>
    import modal from '../../modal'
    import ClientHelper from '../../../components/mixins/client-helper'

    export default {
        name: "add-client-modal",
        components: {
            modal
        },
        mixins: [ClientHelper],
        data() {
            return {
                errors: {},
                formData: {}
            }
        },
        created() {
            this.$eventHub.$on('new-client-added-errors', this.newClientAddedErrorsHandler);
        },
        methods: {
            newClientAddedErrorsHandler(errors) {
                this.errors = errors;
            },
            closeModal() {
                this.$emit('client-modal-closed');
            }
        }
    }
</script>
