<template>
    <div class="list-group shadow">
        <div class="list-group-item">
            <h2>Name</h2>
            <div class="row">
                <div class="col-md-6">
                    <label class="col-form-label" for="project_name">Project Name</label>
                    <input v-model="project.name" class="form-control" id="project_name" name="project_name" type="text" readonly>
                </div>
                <div class="col-md-6" v-if="project.project_type">
                    <label class="col-form-label" for="project_type">Project Type</label>
                    <input v-model="project.project_type.name" class="form-control" id="project_type" name="project_name" type="text" readonly>
                </div>
            </div>
        </div>
        <div class="list-group-item">
            <h2>Client</h2>
            <div class="row">
                <div class="col-md-6" v-if="project.client">
                    <label class="col-form-label" for="client_name" >Client Name</label>
                    <input v-model="project.client.name" class="form-control" id="client_name" name="client_name" type="text" readonly>
                </div>
                <div class="col-md-6" v-if="project.client_contact">
                    <label class="col-form-label" for="client_contact">Client Contact</label>
                    <input v-model="project.client_contact.full_name" class="form-control" id="client_contact" name="client_contact" type="text" readonly>
                </div>
            </div>
        </div>
        <div class="list-group-item">
            <h2>Event</h2>
            <div class="row">
                <div class="col-md-6" v-if="project.event && project.venue">
                    <label class="col-form-label" for="event">Event Name</label>
                    <input v-model="project.event.name" class="form-control" id="event" name="event" type="text" readonly>
                    <label class="col-form-label" for="venue">Event Venue</label>
                    <input v-model="project.venue.name" class="form-control" id="venue" name="venue" type="text" readonly>
                </div>
                <div class="col-md-6" v-if="project.event">
                    <label class="col-form-label" for="event_start_date">Event Start Date</label>
                    <input v-model="project.event.start_date" class="form-control" id="event_start_date" name="event_start_date" type="date" readonly>
                    <label class="col-form-label" for="event_end_date">Event End Date</label>
                    <input v-model="project.event.end_date" class="form-control" id="event_end_date" name="event_end_date" type="date" readonly>
                </div>
            </div>
        </div>
        <div class="list-group-item">
            <h2>Project Details</h2>
            <div class="row">
                <div class="col-md-6" v-if="project.project_owner">
                    <label class="col-form-label" for="user">Project Owner</label>
                    <input v-model="project.project_owner.full_name" class="form-control" id="user" name="user" type="text" readonly>
                </div>
                <div class="col-md-6"  v-if="project.status">
                    <label class="col-form-label" for="status">Status*</label>
                    <input v-model="project.status.name" class="form-control" id="status" name="status" type="text" readonly>
                </div>
            </div>
        </div>
        <div id="add_project_brief_step" class="list-group-item">
            <h2>Design Brief</h2>
            <div class="row">
                <div class="col-md-12">
                    <editor v-model="project.brief" :init="{ branding: false, statusbar: false, menubar: false, height: 300}" plugins="link lists code" toolbar="undo redo formatselect bold italic alignleft aligncenter alignright alignjustify bullist numlist outdent indent link code"></editor>
                </div>
            </div>
            <h2>Private Notes - Not seen by client</h2>
            <div class="row">
                <div class="col-md-12">
                    <editor v-model="project.private_notes"  :init="{ branding: false, statusbar: false, menubar: false, height: 300}" plugins="link lists code" toolbar="undo redo formatselect bold italic alignleft aligncenter alignright alignjustify bullist numlist outdent indent link code"></editor>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "details-tab",
        props: ['project']
    }
</script>
