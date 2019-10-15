<template>
    <tabs :classes="['subtabs']">
        <tab name="Add New Site Survey" selected="selected">
            <add-new-artwork :project_id="project_id" :user_id="user_id" :artwork_type="'Site Survey'"></add-new-artwork>
        </tab>
        <tab name="Existing Site Surveys" :count="site_surveys.length">
            <existing-artwork :artwork="site_surveys" :artwork_type="'Site Surveys'" :user_id="user_id"></existing-artwork>
        </tab>
    </tabs>
</template>

<script>
    import ExistingArtwork from '../existing-artwork'
    import AddNewArtwork from '../add-new-artwork'

    export default {
        name: "site-survey-tab",
        props: ['project_id', 'user_id', 'site_surveys'],
        components: {
            AddNewArtwork,
            ExistingArtwork
        }
    }
</script>
