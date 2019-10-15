<template>
    <div>
        <div v-if="projects.length > 0" class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>Status</th>
                    <th>Project Id</th>
                    <th>Project Name</th>
                    <th>Event</th>
                    <th>Venue</th>
                    <th>Primary Contact</th>
                    <th>Dates</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="project in projects">
                    <td>
                        <span class="text-truncate">{{project.status.name}}</span>
                    </td>
                    <td>
                        <span class="text-truncate">{{project.id}}</span>
                    </td>
                    <td>
                        <span class="text-truncate">{{project.name}}</span>
                    </td>
                    <td>
                        <span class="text-truncate">{{project.event.name}}</span>
                    </td>
                    <td>
                        <span class="text-truncate">{{project.venue.name}}</span>
                    </td>
                    <td>
                        <span class="text-truncate">{{project.client_contact ? project.client_contact.full_name: 'N/A'}}</span>
                    </td>
                    <td>
                        <span class="text-truncate">{{project.event.start_date_formatted}} to {{project.event.end_date_formatted}}</span>
                    </td>
                    <td>
                        <a class="btn btn-sm btn-primary action-btn" :href="$route('staff.project.edit', project.id)">View</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div v-if="!projects.length > 0">
            <p>No projects associated with client</p>
        </div>
    </div>
</template>

<script>
    export default {
        name: "client-projects",
        props: ['projects']
    }
</script>
