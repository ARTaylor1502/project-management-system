<template>
    <modal @close-modal="closeModal">
        <template slot="header">
            Add New Project Accommodation
        </template>
        <template slot="body">
            <form @submit.prevent="addAccommodation">
                <div v-if="venue_selected === true && selected_venue !== null">
                    <div class="form-group">
                        <h4>Selected Venue</h4>
                        <p><i class="far fa-map-marker-alt"></i> {{selected_venue.name}}</p>
                        <p v-if="selected_venue.car_park_type"><i class="far fa-parking"></i> {{selected_venue.car_park_type}}</p>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="add_accommodation_start_date">Start Date</label>
                        <input class="form-control" type="date" id="add_accommodation_start_date" name="add_accommodation_start_date" v-model="form_data['check_in']"/>
                        <ul v-if="errors['check_in']" class="error-list">
                            <li v-for="error in errors['check_in']">{{error}}</li>
                        </ul>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="add_accommodation_end_date">End Date</label>
                        <input class="form-control" type="date" id="add_accommodation_end_date" name="add_accommodation_end_date" v-model="form_data['check_out']"/>
                        <ul v-if="errors['check_out']" class="error-list">
                            <li v-for="error in errors['check_out']">{{error}}</li>
                        </ul>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="add_accommodation_number_of_rooms">Number of Rooms</label>
                        <input class="form-control" type="number" id="add_accommodation_number_of_rooms" name="add_accommodation_number_of_rooms" min="1" v-model="form_data['number_of_rooms']"/>
                        <ul v-if="errors['number_of_rooms']" class="error-list">
                            <li v-for="error in errors['number_of_rooms']">{{error}}</li>
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
                </div>
                <div v-else class="form-group autocomplete">
                    <label class="col-form-label" for="venue_search">Venue Name</label>
                    <div class="autocomplete">
                        <input class="form-control" id="venue_search" name="venue_search" type="text" placeholder="Search for existing venue" v-model="venue_search_query" @keyup="searchVenues">
                        <div v-if="query_results_window_opened" class="options">
                            <div class="options-container">
                                <div v-for="venue in venues" class="option" @click="selectVenueHandler(venue)">{{venue.name}}</div>
                            </div>
                            <div class="trigger" @click="$emit('show-add-venue-modal')">Add New +</div>
                        </div>
                    </div>
                </div>
            </form>
        </template>
    </modal>
</template>

<script>
    import modal from '../../modal'

    export default {
        name: "add-new-project-accommodation",
        props: ['project_id'],
        components: {
            modal
        },
        data() {
          return {
              errors: {},
              venue_search_query: '',
              form_data: {
                  project_id: this.project_id,
                  venue_id: null,
                  check_in: null,
                  check_out: null,
                  number_of_rooms: null,
                  notes: null
              },
              venue_selected: false,
              query_results_window_opened: false,
              venues: [],
              selected_venue: null
          }
        },
        methods: {
            addAccommodation() {
                axios.post(this.$route('api.project.store.accommodation'), this.form_data)
                .then(response => {
                    if(response.data.status === 'success') {
                        this.$emit('project-accommodation-added', response.data);
                    } else if(response.data.status === 'error') {
                        this.errors = response.data.errors;
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            },
            searchVenues() {
                if(this.venue_search_query.length > 2) {
                    axios.post(this.$route('api.venue.search'), {query_string: this.venue_search_query})
                    .then(response => {
                        this.venues = [];

                        response.data.forEach((address) => {
                            this.venues.push(address);
                        });

                        this.query_results_window_opened = true;

                    }).catch(function (error) {
                        console.log(error);
                    });
                }
            },
            selectVenueHandler(venue) {
                this.selected_venue = venue;
                this.form_data.venue_id = venue.id;
                this.venue_selected = true;
                this.query_results_window_opened = false;
            },
            closeModal() {
                this.$emit('add-new-project-accommodation-modal-closed');
            }
        }
    }
</script>
