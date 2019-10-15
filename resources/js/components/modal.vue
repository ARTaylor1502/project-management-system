<template>
    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <div class="modal-header">
                        <h3>
                            <slot name="header"></slot>
                        </h3>
                        <i class="fal fa-times close" @click="closeModal"></i>
                    </div>
                    <div class="modal-body">
                        <slot name="body"></slot>
                    </div>
                    <slot name="footer" class="modal-footer"></slot>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        name: "modal",
        methods: {
            closeModal() {
                this.$emit('close-modal');
            }
        }
    }
</script>
