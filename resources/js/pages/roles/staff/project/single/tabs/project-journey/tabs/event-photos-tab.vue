<template>
    <tabs :classes="['subtabs']">
        <tab name="Add New Event Photo" selected="selected">
            <add-new-artwork :project_id="project_id" :user_id="user_id" :artwork_type="'Event Photo'"></add-new-artwork>
        </tab>
        <tab name="Existing Event Photos" :count="artwork.length">
            <existing-artwork :artwork="artwork" :artwork_type="'Event Photo'" :user_id="user_id"></existing-artwork>
        </tab>
    </tabs>
</template>

<script>
    import ExistingArtwork from '../existing-artwork'
    import AddNewArtwork from '../add-new-artwork'

    export default {
        name: "event-photos-tab",
        props: ['project_id', 'user_id', 'artwork'],
        components: {
            ExistingArtwork,
            AddNewArtwork
        }
    }
</script>
