<template>
    <div id="add_project_name_step" class="list-group-item">
        <h2>Contact Details</h2>
        <div class="row">
            <div class="form-group col-md-6">
                <label class="col-form-label" for="landline_tele">Landline Number</label>
                <input v-model="landline_tele" class="form-control" id="landline_tele" name="landline_tele" type="tel" @keyup="infoChanged">
                <ul v-if="errors['landline_tele']" class="error-list">
                    <li v-for="error in errors['landline_tele']">{{error}}</li>
                </ul>
            </div>
            <div class="form-group col-md-6">
                <label class="col-form-label" for="mobile_number">Mobile Number</label>
                <input v-model="mobile_number" class="form-control" id="mobile_number" name="mobile_number" type="tel" @keyup="infoChanged">
                <ul v-if="errors['mobile_number']" class="error-list">
                    <li v-for="error in errors['mobile_number']">{{error}}</li>
                </ul>
            </div>
            <div class="form-group col-md-6">
                <label class="col-form-label" for="website">Website</label>
                <input v-model="website" class="form-control" id="website" name="website" type="text" @keyup="infoChanged">
                <ul v-if="errors['website']" class="error-list">
                    <li v-for="error in errors['website']">{{error}}</li>
                </ul>
            </div>
            <div class="form-group col-md-6">
                <label class="col-form-label" for="account_manager_id">Account Manager</label>
                <dropdown
                        :label="label"
                        :options="users"
                        :id="'account_manager_id'"
                        value-key="id"
                        label-key="full_name"
                        @input-selected="handler">
                </dropdown>
                <ul v-if="errors['account_manager_id']" class="error-list">
                    <li v-for="error in errors['account_manager_id']">{{error}}</li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    import dropdown from '../../../../../../components/drop-down'

    export default {
        name: "contact-details-step",
        components: {
            dropdown
        },
        props: {
          errors: Object
        },
        data() {
            return {
                landline_tele: '',
                mobile_number: '',
                website: '',
                users: [],
                account_manager: null,
                label: 'Select an Account Manager...',
            }
        },
        mounted() {
          this.loadUsers();
        },
        methods: {
            loadUsers() {
                this.users = [];

                axios.get('/api/user?all=true')
                .then(response => {
                    response.data.forEach((user) => {
                        this.users.push(user);
                    });
                }).catch(function (error) {
                    console.log(error);
                });
            },
            infoChanged() {
                if(this.landline_tele !== '' && this.website !== '' && this.account_manager !== null) {
                    this.$emit('contact-details-step-complete', {
                        landline_tele: this.landline_tele,
                        mobile_number: this.mobile_number,
                        website: this.website,
                        account_manager_id: this.account_manager.id
                    });
                } else {
                    this.$emit('contact-details-step-incomplete');
                }
            },
            handler(e) {
                this.account_manager = e;
                this.infoChanged();
            },
        }
    }
</script>
