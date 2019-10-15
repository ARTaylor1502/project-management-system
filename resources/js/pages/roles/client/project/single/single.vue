<template>
    <div>
        <div class="row">
            <project-summary v-if="project" :project="project"></project-summary>
            <project-status v-if="project" :project="project"></project-status>
        </div>
        <div v-if="project" class="row tabs-row">
            <div id="project_main_details" class="col-md-12">
                <tabs>
                    <tab name="Details">
                        <client-project-details-tab v-if="project" :project="project"></client-project-details-tab>
                    </tab>
                    <tab name="Quote & Products">
                        <client-project-quote-products-tab v-if="project" :project="project"></client-project-quote-products-tab>
                    </tab>
                    <tab name="Project Journey" selected="selected">
                        <tabs :classes="['card-header']">
                            <tab name="Site Survey" selected="selected" :count="site_surveys.length">
                                <artwork-items :artwork="site_surveys" artwork_type="Site Surveys"></artwork-items>
                            </tab>
                            <tab name="Design & Concept" :count="concept_artwork.length">
                                <artwork-items :artwork="concept_artwork" artwork_type="Design & Concept"></artwork-items>
                            </tab>
                            <tab name="Artwork" :count="general_artwork.length">
                                <artwork-items :artwork="general_artwork" artwork_type="Artwork"></artwork-items>
                            </tab>
                            <tab name="Event Photos" :count="event_photos.length">
                                <artwork-items :artwork="event_photos" artwork_type="Event Photos"></artwork-items>
                            </tab>
                            <tab name="Sign-off"></tab>
                        </tabs>
                    </tab>
                </tabs>
            </div>
        </div>
        <client-project-journey-modals :project_id="project_id" :user_id="user_id"></client-project-journey-modals>
    </div>
</template>

<script>
    import ArtworkHelper from '../../../../../components/mixins/artwork-helper';

    import ProjectSummary from './quick-info/project-summary';
    import ProjectStatus from './quick-info/project-status';
    import ClientProjectDetailsTab from './tabs/details-tab';
    import ClientProjectQuoteProductsTab from './tabs/quote-products-tab';
    import ArtworkItems from './tabs/project-journey/artwork-items'
    import ClientProjectJourneyModals from './tabs/project-journey/modals'

    export default {
        name: "client-project",
        components: {
            ProjectSummary,
            ProjectStatus,
            ClientProjectDetailsTab,
            ClientProjectQuoteProductsTab,
            ArtworkItems,
            ClientProjectJourneyModals
        },
        mixins: [ArtworkHelper],
        props: ['project_id', 'user_id'],
        data() {
            return {
                project: false,
                selected_artwork: false,
                approveArtworkModalActive: false,
                requestAmendsModalActive: false,
                selected_amend_request: false,
                AmendsMadeComparisonModalActive: false,
                viewAmendRequestModalActive: false,
                successModalActive: false,
                successBodyContent: ''
            }
        },
        mounted() {
            this.$eventHub.$on('artwork-updated', this.loadProjectArtwork);
        },
        created() {
            this.loadProject(this.project_id);
            this.loadProjectArtwork(this.project_id);
        },
        computed: {
            concept_artwork() {
                return this.artwork_formatted.filter(function (a) {
                    return a.artwork_type.name === 'Design & Concept' && a.internally_approved;
                });
            },
            site_surveys() {
                return this.artwork_formatted.filter(function (a) {
                    return a.artwork_type.name === 'Site Survey' && a.internally_approved;
                });
            },
            general_artwork() {
                return this.artwork_formatted.filter(function (a) {
                    return a.artwork_type.name === 'Artwork' && a.internally_approved;
                });
            },
            event_photos() {
                return this.artwork_formatted.filter(function (a) {
                    return a.artwork_type.name === 'Event Photo' && a.internally_approved;
                });
            }
        },
        methods: {
            loadProject() {
                let self = this;

                axios.get(this.$route('api.project.single', this.project_id))
                .then(response => {
                    self.project = response.data;
                }).catch(function (error) {
                    console.log(error);
                });
            },
            loadProjectArtwork() {
                let self = this;

                this.artwork = [];

                axios.get('/api/project/'+self.project_id+'/all-artwork')
                .then(response => {
                    response.data.forEach((artwork) => {
                        this.artwork.push(artwork);
                    });
                }).catch(function (error) {
                    console.log(error);
                });
            }
        }
    }
</script>
