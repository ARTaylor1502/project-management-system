<template>
    <tabs :classes="['subtabs']">
        <tab name="Site Survey" selected="selected" :count="site_surveys.length">
            <internal-approval-artwork :artwork="site_surveys" :category_type="'Site Surveys'"></internal-approval-artwork>
        </tab>
        <tab name="Design & Concept" :count="concept_artwork.length">
            <internal-approval-artwork :artwork="concept_artwork" :category_type="'Design & Concept Artwork'"></internal-approval-artwork>
        </tab>
        <tab name="Artwork" :count="general_artwork.length">
            <internal-approval-artwork :artwork="general_artwork" :category_type="'Artwork'"></internal-approval-artwork>
        </tab>
    </tabs>
</template>

<script>
    import InternalApprovalArtwork from './internal-approval-artwork'

    export default {
        name: "internal-approval-tab",
        components: {
            InternalApprovalArtwork
        },
        props: {
            project_id: Number,
            user_id: Number,
            artwork: Array
        },
        data() {
            return {
                errors: {}
            }
        },
        computed: {
            site_surveys() {
                return this.artwork.filter(function (a) {
                    return a.artwork_type.name === 'Site Survey';
                });
            },
            concept_artwork() {
                return this.artwork.filter(function (a) {
                    return a.artwork_type.name === 'Design & Concept';
                });
            },
            general_artwork() {
                return this.artwork.filter(function (a) {
                    return a.artwork_type.name === 'Artwork';
                });
            }
        }
    }
</script>
