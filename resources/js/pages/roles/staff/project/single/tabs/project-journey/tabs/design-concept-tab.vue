<template>
    <tabs :classes="['subtabs']">
        <tab name="Add New Design & Concept Artwork" selected="selected">
            <add-new-artwork :project_id="project_id" :user_id="user_id" :artwork_type="'Design & Concept'"></add-new-artwork>
        </tab>
        <tab name="Existing Design & Concept Artwork" :count="existing_concept_artwork.length">
           <existing-artwork :artwork="existing_concept_artwork" :artwork_type="'Design & Concept Artwork'" :user_id="user_id"></existing-artwork>
        </tab>
    </tabs>
</template>

<script>
    import ExistingArtwork from '../existing-artwork'
    import AddNewArtwork from '../add-new-artwork'

    export default {
        name: "design-concept-tab",
        props: ['project_id', 'user_id', 'existing_concept_artwork'],
        components: {
            ExistingArtwork,
            AddNewArtwork
        }
    }
</script>
