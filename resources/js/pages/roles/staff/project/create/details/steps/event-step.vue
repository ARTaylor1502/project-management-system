<template>
    <li id="add_project_event_step" class="list-group-item">
        <h2>Event</h2>
        <div class="row">
            <div class="col-md-6">
                <label class="col-form-label" for="event_id">Event Name</label>
                <dropdown
                        :label="'Select an Event...'"
                        :options="events"
                        :id="'event_id'"
                        :triggerName = "'Add New +'"
                        value-key="id"
                        label-key="name"
                        @input-selected="eventHandler"
                        @trigger-activated="addEventModalActive = true">
                </dropdown>
                <label class="col-form-label" for="venue_id">Event Venue</label>
                <dropdown
                        :label="'Select a Venue...'"
                        :options="venues"
                        :id="'venue_id'"
                        :triggerName = "'Add New +'"
                        value-key="id"
                        label-key="name"
                        @input-selected="venueHandler"
                        @trigger-activated="addVenueModalActive = true">
                </dropdown>
            </div>
            <div class="col-md-6">
                <label class="col-form-label" for="event_start_date">Event Start Date</label>
                <time class="form-control" id="event_start_date" type="datetime" :value="event_start_date" disabled>{{event.start_date_formatted}}</time>
                <label class="col-form-label" for="event_end_date">Event End Date</label>
                <time class="form-control" id="event_end_date" type="datetime" :value="event_end_date" disabled>{{event.end_date_formatted}}</time>
            </div>
        </div>
        <add-event-modal v-show="addEventModalActive === true"
                       @event-added="eventAddedHandler"
                       @event-modal-closed="addEventModalActive = false">
        </add-event-modal>
        <add-venue-modal v-show="addVenueModalActive === true"
                       @venue-added="venueAddedHandler"
                       @venue-modal-closed="addVenueModalActive = false">
        </add-venue-modal>
        <modal v-show="successModalActive === true"
               @close-modal="closeSuccessModal">
            <template slot="header">
                Success
            </template>
            <template slot="body">
                {{successBodyContent}}
            </template>
        </modal>
    </li>
</template>

<script>
    import dropdown from '../../../../../../../components/drop-down'
    import modal from '../../../../../../../components/modal'
    import addEventModal from '../../../../../../../components/modals/event/add-event-modal'
    import addVenueModal from '../../../../../../../components/modals/venue/add-venue-modal'
    import VenueHelper from '../../../../../../../components/mixins/venue-helper'
    import EventHelper from '../../../../../../../components/mixins/event-helper'

    export default {
        name: "event-step",
        components: {
            dropdown,
            modal,
            addEventModal,
            addVenueModal
        },
        mixins: [VenueHelper, EventHelper],
        data() {
            return {
                errors: {},
                events: [],
                event_start_date: null,
                event_end_date: null,
                venues: [],
                event: {},
                venue: {},
                addEventModalActive: false,
                addVenueModalActive: false,
                successModalActive: false,
                successBodyContent: ''
            }
        },
        mounted(){
            this.loadEvents({all:true});
            this.loadVenues({all:true});
        },
        methods: {
            infoChanged() {
                if(this.event.id && this.venue.id) {
                    this.$emit('event-step-complete', {
                        event: this.event,
                        venue: this.venue
                    });
                } else {
                    this.$emit('event-step-incomplete');
                }
            },
            eventAddedHandler(event_added_message) {
                this.showSuccessModal(event_added_message);
                this.loadEvents();
            },
            venueAddedHandler(venue_added_message) {
                this.showSuccessModal(venue_added_message);
                this.loadVenues();
            },
            updateEventDates() {
                this.event_start_date = this.event.start_date;
                this.event_end_date = this.event.end_date;
            },
            eventHandler(e) {
                this.event = e;
                this.updateEventDates();
                this.infoChanged();
            },
            venueHandler(e) {
                this.venue = e;
                this.infoChanged();
            },
            showSuccessModal(modal_content) {
                this.successBodyContent = modal_content;
                this.successModalActive = true;
            },
            closeSuccessModal() {
                this.successModalActive = false;
            }
        }
    }
</script>
