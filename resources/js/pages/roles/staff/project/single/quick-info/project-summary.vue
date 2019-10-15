<template>
    <div class="col-md-6 col-lg-4">
        <h2>Summary</h2>
        <div id="summary" class="card h-100">
            <div class="card-body">
                <ul class="list mb-0">
                    <li class="mb-3">
                        <i class="fal fa-calendar-alt list-icon mr-3"></i>
                        <span><span class="title">Event:</span> {{project.event.name}}</span>
                    </li>
                    <li class="mb-3">
                        <i class="fal fa-clock list-icon mr-3"></i>
                        <span><span class="title">Event Date:</span> {{project.event.start_date_formatted}} to {{project.event.end_date_formatted}}</span>
                    </li>
                    <li class="mb-3">
                        <i class="fal fa-map-marker-alt list-icon mr-3"></i>
                        <span><span class="title">Venue:</span> {{project.venue.name}}</span>
                    </li>
                    <li class="mb-3">
                        <i class="fal fa-user-friends list-icon mr-3"></i>
                        <span><span class="title">Client:</span> <a :href="$route('staff.client.edit', project.client.id)">{{project.client.name}}</a></span>
                    </li>
                    <li class="mb-3">
                        <i class="fal fa-id-badge list-icon mr-3"></i>
                        <span><span class="title">Primary Contact:</span> {{project.client_contact.full_name}}</span>
                    </li>
                    <li class="mb-0">
                        <i class="fal fa-alarm-clock list-icon mr-3"></i>
                        <span><span class="title">Last Updated:</span> {{project.last_updated_formatted}}</span>
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
