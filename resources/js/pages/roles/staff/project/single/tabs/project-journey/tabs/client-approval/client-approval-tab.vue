<template>
    <div>
        <tabs :classes="['subtabs']">
            <tab name="Site Survey" selected="selected" :count="site_surveys.length">
                <client-approval-artwork :artwork="site_surveys" :category_type="'Site Surveys'" :project_id="project_id"></client-approval-artwork>
            </tab>
            <tab name="Design & Concept" :count="concept_artwork.length">
                <client-approval-artwork :artwork="concept_artwork" :category_type="'Design & Concept'" :project_id="project_id"></client-approval-artwork>
            </tab>
            <tab name="Artwork" :count="general_artwork.length">
                <client-approval-artwork :artwork="general_artwork" :category_type="'Artwork'" :project_id="project_id"></client-approval-artwork>
            </tab>
        </tabs>
    </div>
</template>

<script>
    import ClientApprovalArtwork from './client-approval-artwork'

    export default {
        name: "client-approval-tab",
        components: {
            ClientApprovalArtwork
        },
        props: {
            project_id: Number,
            artwork: Array
        },
        computed: {
            site_surveys() {
                return this.artwork.filter(function (a) {
                    return a.artwork_type.name === 'Site Survey' && a.internally_approved;
                });
            },
            concept_artwork() {
                return this.artwork.filter(function (a) {
                    return a.artwork_type.name === 'Design & Concept' && a.internally_approved;
                });
            },
            general_artwork() {
                return this.artwork.filter(function (a) {
                    return a.artwork_type.name === 'Artwork' && a.internally_approved;
                });
            }
        }
    }
</script>
