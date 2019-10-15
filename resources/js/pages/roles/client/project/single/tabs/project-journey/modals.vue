<template>
    <div>
        <approve-artwork-modal v-if="artworkApprovalModalActive && selected_artwork"
                               :project_id="project_id"
                               :artwork="selected_artwork"
                               :client_id="user_id"
                               @artwork-approved="showSuccessModal"
                               @approve-artwork-modal-closed="artworkApprovalModalActive = false">
        </approve-artwork-modal>
        <request-amends-modal v-if="selected_artwork !== null && requestAmendsModalActive"
                              :project_id="project_id"
                              :artwork="selected_artwork"
                              :client_id="user_id"
                              @requested-amend-added="showSuccessModal"
                              @request-amends-modal-closed="requestAmendsModalActive = false">
        </request-amends-modal>
        <view-amend-request-modal v-if="selected_amend_request && viewAmendRequestsModalActive"
                                  :amend_request="selected_amend_request"
                                  @view-artwork-amend-requests-modal-closed="viewAmendRequestsModalActive = false">
        </view-amend-request-modal>
        <amends-made-comparison-modal v-if="amendsMadeComparisonModalActive"
                                      :project_id="project_id"
                                      :client_id="user_id"
                                      :amend_request="amend_request"
                                      :previous_artwork="previous_artwork"
                                      :amended_artwork="amended_artwork"
                                      @amend-approved="showSuccessModal"
                                      @amends-made-modal-closed="amendsMadeComparisonModalActive = false">
        </amends-made-comparison-modal>
        <modal v-show="successModalActive === true"
               @close-modal="successModalActive = false">
            <template slot="header">Success</template>
            <template slot="body">{{successBodyContent}}</template>
        </modal>
    </div>
</template>

<script>
    import modal from '../../../../../../../components/modal'
    import ViewAmendRequestModal from '../../../../../../../components/modals/artwork-amends/view-amend-request-modal'
    import ApproveArtworkModal from '../../../../../../../components/modals/artwork-amends/approve-artwork-modal'
    import AmendsMadeComparisonModal from '../../../../../../../components/modals/artwork-amends/amends-made-comparison-modal'
    import RequestAmendsModal from '../../../../../../../components/modals/artwork-amends/request-amends-modal'

    export default {
        name: "client-project-journey-modals",
        components: {
            modal,
            RequestAmendsModal,
            ViewAmendRequestModal,
            AmendsMadeComparisonModal,
            ApproveArtworkModal,
        },
        props: ['project_id', 'user_id'],
        data() {
            return {
                selected_artwork: false,
                selected_artwork_index: false,
                amend_request: false,
                previous_artwork: false,
                amended_artwork: false,
                selected_amend_request: false,
                amendsMadeComparisonModalActive: false,
                artworkApprovalModalActive: false,
                requestAmendsModalActive: false,
                viewAmendRequestsModalActive: false,
                addAmendsModalActive: false,
                successModalActive: false,
                successBodyContent: ''
            }
        },
        mounted() {
            this.$eventHub.$on('request-artwork-approval', this.approveArtworkModalTrigger);
            this.$eventHub.$on('request-artwork-amends', this.requestArtworkAmendsModalTrigger);
            this.$eventHub.$on('view-amends-comparison', this.viewAmendsComparisonModalTrigger);
            this.$eventHub.$on('view-amend-request', this.viewAmendRequestModalTrigger);
            this.$eventHub.$on('add-amended-artwork', this.addAmendedArtworkModalTrigger);
            this.$eventHub.$on('get-what3words-code', this.what3WordsCodeModalTrigger);
        },
        methods: {
            approveArtworkModalTrigger(artwork) {
                this.selected_artwork = artwork;
                this.artworkApprovalModalActive = true;
            },
            requestArtworkAmendsModalTrigger(artwork) {
                this.selected_artwork = artwork;
                this.requestAmendsModalActive = true;
            },
            viewAmendsComparisonModalTrigger(e) {
                this.amend_request = e.amend_request;
                this.previous_artwork = e.previous_artwork;
                this.amended_artwork = e.amended_artwork;
                this.amendsMadeComparisonModalActive = true;
            },
            viewAmendRequestModalTrigger(amend_request) {
                this.selected_amend_request = amend_request;
                this.viewAmendRequestsModalActive = true;
            },
            showSuccessModal(message) {
                this.successBodyContent = message;
                this.successModalActive = true;
            },
            closeSuccessModal() {
                this.successModalActive = false;
            }
        }
    }
</script>
