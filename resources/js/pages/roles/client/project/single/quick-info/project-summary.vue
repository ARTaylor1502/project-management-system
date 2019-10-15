<template>
    <div class="col-md-6 col-lg-4">
        <h2>Summary</h2>
        <div id="summary" class="card project-details summary-card">
            <div class="card-body">
                <ul>
                    <li>
                        <i class="fal fa-calendar-alt"></i>
                        <span>Event: {{project.event.name}}</span>
                    </li>
                    <li>
                        <i class="fal fa-clock"></i>
                        <span>Event Date: {{project.event.start_date_formatted}} to {{project.event.end_date_formatted}}</span>
                    </li>
                    <li>
                        <i class="fal fa-map-marker-alt"></i>
                        <span>Venue: {{project.venue.name}}</span>
                    </li>
                    <li>
                        <i class="fal fa-user-friends"></i>
                        <span>Client: <a :href="$route('staff.client.edit', project.client.id)">{{project.client.name}}</a></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "project-summary",
        props: ['project']
    }
</script>
