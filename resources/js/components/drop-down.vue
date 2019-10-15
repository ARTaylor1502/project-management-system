<template>
    <div class="select-with-trigger form-control" :id="id">
        <div @click="toggle" class="label">
            <span class="label-text">{{value}} <i class="fas fa-caret-down"></i></span>
        </div>
        <div v-if="opened" class="options">
            <div class="options-container">
                <div v-for="o in options" @click="change(o)" class="option">{{ getLabel(o) }}</div>
            </div>
            <div v-if="triggerName" class="trigger" @click="triggerActivated">{{triggerName}}</div>
        </div>
        <div v-if="opened" @click="toggle" class="overlay"></div>
    </div>
</template>

<script>
    export default {
        name: "drop-down",
        data () {
            return {
                opened: false,
                value: null,
                initialLabel: ''
            }
        },
        props: {
            id : {
                type: String,
                required: true
            },
            label: {
                type: String,
                required: true
            },
            options: {
                type: Array,
                required: true
            },
            triggerName: {
                type: String
            },
            labelSeparator: {
                type: String,
                required: false
            },
            valueKey: {
                type: String,
                required: false
            },
            labelKey: {
                type: String,
                required: false
            },
            labelKey2: {
                type: String,
                required: false
            }
        },
        mounted() {
            this.setLabel();
            this.setInitialLabel();
        },
        methods: {
            setInitialLabel() {
                this.initialLabel = this.label;
            },
            setLabel() {
                this.value = this.label;
            },
            getVal(opt) {
                return !this.valueKey ? opt : opt[this.valueKey]
            },
            getLabel(opt) {
                if(this.labelKey2 && this.labelSeparator) {
                    return opt[this.labelKey] + ' ' + this.labelSeparator + opt[this.labelKey2];
                } else {
                    return !this.labelKey ? opt : opt[this.labelKey];
                }
            },
            change(opt) {
                this.$emit('input-selected', opt);
                this.opened = false;

                this.value = this.getLabel(opt);
            },
            toggle() {
                this.opened = !this.opened
            },
            triggerActivated() {
                this.$emit('trigger-activated');
            }
        },
        watch: {
            label: function (val) {
                if(val !== this.initialLabel) {
                    this.setLabel();
                    this.opened = false;
                }
            },
            options: function(){
                if(this.options.length === 0) {
                    this.setLabel();
                }
            },
            deep: true,
            immediate: true,
        }
    }
</script>