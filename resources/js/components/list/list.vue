<template>
    <div>
        <ul v-if="items.length > 0" :class="classes">
            <li v-for="item in items">{{item}}</li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "list",
        props: {
            items: {
                type: Array,
                required: true
            },
            classes: {
                type: Array,
                required: true
            }
        }
    }
</script>