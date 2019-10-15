<template>
    <div class="filters row">
        <div class="col-sm-2">
            <label for="search_events">Search:</label>
            <input type="text" id="search_events" class="form-control" @keyup="searchQueryHandler" v-model="search_query" placeholder="Find an event">
        </div>
        <div class="col-sm-2">
            <label for="filter_events">Filter By:</label>
            <select id="filter_events" class="form-control" @change="loadEvents" v-model="filter_value">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
        <div class="col-sm-2">
            <label for="sort_events">Sort By:</label>
            <select id="sort_events" class="form-control" @change="loadEvents" v-model="sort_value">
                <option value="start_date_asc">Soonest</option>
                <option value="name_asc">A - Z</option>
                <option value="name_desc">Z - A</option>
            </select>
        </div>
    </div>
    <template v-if="venues.length > 0">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                    <tr>
                        <th>Event</th>
                        <th>Date and Time</th>
                        <th>Days Until Event</th>
                        <th>Address</th>
                        <th>Clients with Projects at this Event</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="event in events">
                        <td>
                            <span class="text-truncate">{{event.name}}</span>
                        </td>
                        <td>
                            <ul>
                                <li class="text-truncate">{{event.start_date_formatted}}</li>
                                <li class="text-truncate">{{event.start_time_formatted}}</li>
                            </ul>
                        </td>
                        <td>
                            <span class="text-truncate">{{event.time_until_event.days}}</span>
                        </td>
                        <td>
                            <span class="text-truncate">{{event.venue_address}}</span>
                        </td>
                        <td>
                            <ul>
                                <li v-for="client in event.clients" class="text-truncate"><a :href="$route('staff.client.edit' + client.id)">{{client.name}}</a></li>
                            </ul>
                        </td>
                        <td>
                            <a class="btn btn-sm btn-primary action-btn" :href="$route('staff.event.edit', event.id)">View</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <pagination v-if="number_of_pages > 1" :pagesCount="number_of_pages" :currentPageNumber="page_number" @page-changed="pageChangedHandler"></pagination>
    </template>
    <template v-if="!venues.length > 0">
        <p>No venues found</p>
    </template>
</template>

<script>
    export default {
        name: "venues-list",
        data() {
            return {
                venues: [],
                number_of_pages: 0,
                page_number: 1,
                sort_value: 'name_asc',
                search_query: ''
            }
        },
        created() {
            this.loadEvents();
        },
        methods: {
            loadEvents() {
                let self = this, url = '/api/event?page=' + self.page_number + '&order='+self.sort_value;

                if(self.search_query.length > 2) {
                    url += '&search=' + self.search_query;
                }

                self.resetEvents();

                axios.get(url)
                .then(response => {
                    response.data.data.forEach(function(client) {
                        self.events.push(client);
                    });
                    self.number_of_pages = response.data.last_page;
                    self.page_number = response.data.current_page;
                    self.$eventHub.$emit('count-updated', response.data.total);
                }).catch(function (error) {
                    console.log(error);
                });
            },
            resetEvents() {
                this.events = [];
            },
            pageChangedHandler(page_number) {
                this.page_number = page_number;
                this.loadEvents();
            },
            searchQueryHandler() {
                this.loadEvents();
            }
        }
    }
</script>
