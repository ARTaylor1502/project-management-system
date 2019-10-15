<template>
    <span>{{count_number}}</span>
</template>

<script>
    export default {
        name: "counter",
        data() {
            return {
                count_number: 0
            }
        },
        mounted() {
            this.$eventHub.$on('count-updated', this.updateCount);
        },
        methods: {
            updateCount(count) {
                this.count_number = count;
            }
        }
    }
</script>

