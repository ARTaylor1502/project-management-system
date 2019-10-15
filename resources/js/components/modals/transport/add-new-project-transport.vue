<template>
    <modal @close-modal="closeModal">
        <template slot="header">
            Add New Project Transport
        </template>
        <template slot="body">
            <form @submit.prevent="addTransport">
                <div class="form-group">
                    <label class="col-form-label" for="add_transport_start_date">Start Date</label>
                    <input class="form-control" type="date" id="add_transport_start_date" name="add_transport_start_date" v-model="form_data['start_date']"/>
                    <ul v-if="errors['start_date']" class="error-list">
                        <li v-for="error in errors['start_date']">{{error}}</li>
                    </ul>
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="add_transport_end_date">End Date</label>
                    <input class="form-control" type="date" id="add_transport_end_date" name="add_transport_end_date" v-model="form_data['end_date']"/>
                    <ul v-if="errors['end_date']" class="error-list">
                        <li v-for="error in errors['end_date']">{{error}}</li>
                    </ul>
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="add_accommodation_rental_company">Rental Company</label>
                    <input type="text" class="form-control" id="add_accommodation_rental_company" name="add_accommodation_rental_company" v-model="form_data['rental_company']"/>
                    <ul v-if="errors['rental_company']" class="error-list">
                        <li v-for="error in errors['rental_company']">{{error}}</li>
                    </ul>
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="add_accommodation_name">Vehicle Name</label>
                    <input type="text" class="form-control" id="add_accommodation_name" name="add_accommodation_name" v-model="form_data['name']"/>
                    <ul v-if="errors['name']" class="error-list">
                        <li v-for="error in errors['name']">{{error}}</li>
                    </ul>
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="vehicle_type_id">Vehicle Type</label>
                    <select id="vehicle_type_id" class="form-control" v-model="form_data['vehicle_type_id']">
                        <option v-for="vehicle_type in vehicle_types" name="vehicle_type_id" :value="vehicle_type.id">{{vehicle_type.name}}</option>
                    </select>
                    <ul v-if="errors['vehicle_type_id']" class="error-list">
                        <li v-for="error in errors['vehicle_type_id']">{{error}}</li>
                    </ul>
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="add_accommodation_license_plate">License Plate</label>
                    <input type="text" class="form-control" id="add_accommodation_license_plate" name="add_accommodation_license_plate" v-model="form_data['license_plate']"/>
                    <ul v-if="errors['license_plate']" class="error-list">
                        <li v-for="error in errors['license_plate']">{{error}}</li>
                    </ul>
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="add_accommodation_colour">Colour</label>
                    <input type="text" class="form-control" id="add_accommodation_colour" name="add_accommodation_colour" v-model="form_data['colour']"/>
                    <ul v-if="errors['colour']" class="error-list">
                        <li v-for="error in errors['colour']">{{error}}</li>
                    </ul>
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="add_accommodation_notes">Notes</label>
                    <textarea class="form-control" id="add_accommodation_notes" name="add_accommodation_notes" v-model="form_data['notes']"></textarea>
                    <ul v-if="errors['notes']" class="error-list">
                        <li v-for="error in errors['notes']">{{error}}</li>
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
        name: "add-new-project-transport",
        props: ['project_id'],
        components: {
            modal
        },
        data() {
            return {
                errors: {},
                form_data: {
                    project_id: this.project_id,
                    start_date: null,
                    end_date: null,
                    rental_company: null,
                    vehicle_type_id: null,
                    license_plate: null,
                    colour: null,
                    notes: null
                },
                vehicle_types: [],
            }
        },
        created() {
            this.loadVehicleTypes();
        },
        methods: {
            addTransport() {
                axios.post(this.$route('api.project.store.transport'), this.form_data)
                .then(response => {
                    if(response.data.status === 'success') {
                        this.$emit('project-transport-added', response.data);
                    } else if(response.data.status === 'error') {
                        this.errors = response.data.errors;
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            },
            loadVehicleTypes() {
                let self = this;

                axios.get(this.$route('api.project.transport.vehicle.types'))
                .then(response => {
                    response.data.forEach(function(vehicle_type) {
                        self.vehicle_types.push(vehicle_type);
                    });

                    if(this.vehicle_types.length > 0) {
                        self.form_data.vehicle_type_id = self.vehicle_types[0].id;
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            },
            closeModal() {
                this.$emit('add-new-project-transport-modal-closed');
            }
        }
    }
</script>
