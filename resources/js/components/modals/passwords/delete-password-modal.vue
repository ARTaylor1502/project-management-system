<template>
    <modal @close-modal="closeModal">
        <template slot="header">
            Delete Password
        </template>
        <template slot="body">
            <p>Are you sure you wish to delete this password?</p>
            <div class="text-center mt-5">
                <button class="btn btn-lg btn-primary mr-2" @click="confirmAction">Yes</button>
                <button class="btn btn-lg btn-secondary" @click="closeModal">No</button>
            </div>
        </template>
    </modal>
</template>

<script>
    import modal from '../../modal'

    export default {
        name: "delete-client-password-modal",
        components: {
            modal
        },
        methods: {
            confirmAction() {
                this.$emit('action-confirmed');
            },
            closeModal() {
                this.$emit('delete-client-password-modal-closed');
            }
        }
    }
</script>
