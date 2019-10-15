<template>
    <div class="list-group-item">
        <h2>Contact Details</h2>
        <div class="row">
            <div class="form-group col-md-6">
                <label class="col-form-label" for="email">Email</label>
                <input v-model="email" class="form-control" id="email" name="email" type="email" @keyup="infoChanged">
                <ul v-if="errors['email']" class="error-list">
                    <li v-for="error in errors['email']">{{error}}</li>
                </ul>
            </div>
            <div class="form-group col-md-6">
                <label class="col-form-label" for="mobile_tele">Mobile</label>
                <input v-model="mobile_tele" class="form-control" id="mobile_tele" name="mobile_tele" type="tel" @keyup="infoChanged">
                <ul v-if="errors['mobile_tele']" class="error-list">
                    <li v-for="error in errors['mobile_tele']">{{error}}</li>
                </ul>
            </div>
            <div class="form-group col-md-6">
                <label class="col-form-label" for="landline_tele">Landline</label>
                <input v-model="landline_tele" class="form-control" id="landline_tele" name="landline_tele" type="tel" @keyup="infoChanged">
                <ul v-if="errors['landline_tele']" class="error-list">
                    <li v-for="error in errors['landline_tele']">{{error}}</li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "contact-details-step",
        props: {
            errors: Object
        },
        data() {
            return {
                email: null,
                landline_tele: null,
                mobile_tele: null
            }
        },
        methods: {
            infoChanged() {
                if(this.email !== null && this.landline_tele !== null && this.mobile_tele !== null) {
                    this.$emit('contact-details-step-complete', {
                        email: this.email,
                        landline_tele: this.landline_tele,
                        mobile_tele: this.mobile_tele
                    });
                } else {
                    this.$emit('contact-details-step-incomplete');
                }
            },
        }
    }
</script>