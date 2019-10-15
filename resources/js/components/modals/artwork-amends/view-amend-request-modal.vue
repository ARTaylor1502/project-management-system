<template>
    <modal @close-modal="closeModal">
        <template slot="header">Amend Requests</template>
        <template slot="body">
            <div class="form-group amend-list-item mb-0">
                <h4 v-if="amend_request.internal_requester">Requested by: {{amend_request.internal_requester.full_name}} at {{amend_request.createdAtTimeFormatted}} on {{amend_request.createdAtDateFormatted}}</h4>
                <h4 v-if="amend_request.client_requester">Requested by: {{amend_request.client_requester.full_name}} at {{amend_request.createdAtTimeFormatted}} on {{amend_request.createdAtDateFormatted}}</h4>
                <editor v-model="amend_request.description" :init="{ branding: false, statusbar: false, menubar: false,  toolbar: false, height: 150, readonly: 1}" readonly></editor>
                <template v-if="amend_request.file">
                    <h4 class="mt-5 mb-3">Amends Doc</h4>
                    <div class="d-flex align-items-center">
                        <div class="mr-auto">{{amend_request.file.name}}</div>
                        <a :href="amend_request.file.src" download class="btn btn-primary btn-sm cta-item"><i class="fal fa-download"></i></a>
                    </div>
                </template>
            </div>
        </template>
    </modal>
</template>

<script>
    import modal from '../../modal'

    export default {
        name: "view-amend-request-modal",
        components: {
            modal
        },
        props: ['amend_request'],
        methods: {
            closeModal() {
                this.$emit('view-artwork-amend-requests-modal-closed');
            }
        }
    }
</script>
