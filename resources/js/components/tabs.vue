<template>
    <div>
        <div class="tabs" :class="classes">
            <ul class="tab-list">
                <li v-for="tab in tabs_formatted" class="tab-header" :class="{'is-active' : tab.isActive}">
                    <a :href="tab.href" @click="selectTab(tab)">{{tab.name}} <span class="badge">{{tab.count}}</span></a>
                </li>
            </ul>
            <slot name="tab_additional"></slot>
        </div>
        <div class="tab-details">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        name: "tabs",
        props: {
            classes: {
                type: Array,
                required: false
            }
        },
        data() {
            return {
                tabs : []
            }
        },
        created() {
            this.tabs = this.$children;
        },
        computed: {
            tabs_formatted() {
                return this.tabs.filter(function(tab) {
                    return tab.name;
                });
            }
        },
        methods: {
            selectTab(selectedTab) {
                this.tabs.forEach(tab => {
                    tab.isActive = (tab.name === selectedTab.name);
                })
            }
        }
    }
</script>
