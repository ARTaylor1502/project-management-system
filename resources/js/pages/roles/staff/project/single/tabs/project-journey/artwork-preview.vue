<template>
    <div class="artwork-preview">
        <img class="preview" :src="artwork_src"/>
        <div class="preview-actions">
            <a :href="artwork_src" download><i class="fal fa-download download-icon"></i></a><a :href="artwork_src" target="_blank"><i class="fal fa-search-plus magnify-icon"></i></a>
        </div>
    </div>
</template>

<script>
    export default {
        name: "artwork-preview",
        props: ['artwork_src']
    }
</script>
