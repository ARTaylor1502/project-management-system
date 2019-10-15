<template>
    <div class="quantity-selector-container">
        <div class="form-row">
            <label class="col-form-label">
                <slot name="label"></slot>
            </label>
        </div>
        <div class="form-row">
            <div class="form-group col-sm-10">
                <input class="form-control" :value="value" />
            </div>
            <div class="form-group col-sm-2">
                <i class="fal fa-minus quantity-control quantity-down" @click="decreaseQuantity"></i><i class="fal fa-plus quantity-control quantity-up" @click="increaseQuantity"></i>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "quantity-selector",
        props: ['value'],
        data() {
            return { quantity: this.value }
        },
        methods: {
            increaseQuantity() {
                this.quantity++;
            },
            decreaseQuantity() {
                this.quantity--;
            }
        },
        watch: {
            quantity(val) {
                this.$emit('input', val);
            }
        }
    }
</script>