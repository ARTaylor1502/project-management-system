<template>
    <button class="btn pill-button" @click="$emit('clicked')">
       <span class="left-section"><slot name="button_text"></slot></span><span class="right-section"><slot name="cta_text"></slot></span>
    </button>
</template>

<script>
    export default {
        name: "pill-button"
    }
</script>
