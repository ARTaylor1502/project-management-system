<template>
    <tabs :classes="['subtabs']">
        <tab name="Add New Artwork" selected="selected">
           <add-new-artwork :project_id="project_id" :user_id="user_id" :artwork_type="'Artwork'"></add-new-artwork>
        </tab>
        <tab name="Existing Artwork" :count="existing_artwork.length">
            <existing-artwork :artwork="existing_artwork" :artwork_type="'Artwork'" :user_id="user_id"></existing-artwork>
        </tab>
    </tabs>
</template>

<script>
    import ExistingArtwork from '../existing-artwork'
    import AddNewArtwork from '../add-new-artwork'

    export default {
        name: "artwork-tab",
        props: ['project_id', 'user_id', 'existing_artwork'],
        components: {
            ExistingArtwork,
            AddNewArtwork
        }
    }
</script>
