<template>
    <div class="list-item task mb-2">
        <span class="row">
            <span class="col-md-9">
                <i v-if="draggable" class="fal fa-arrows drag-icon mr-3"></i><span :class="completed ? 'tick-box-container completed mr-3' : 'tick-box-container mr-3'" @click="markTaskCompleted(task.id)"><i class="fal fa-square tick-base"><i class="fal fa-check tick-overlay"></i></i></span>
                <slot name="task-name"></slot>
            </span>
            <span class="col-md-3 right-container">
                <slot name="right-container"></slot>
            </span>
        </span>
    </div>
</template>

<script>
    import TaskHelper from '../../components/mixins/task-helper'

    export default {
        name: "task-list-item",
        props: {
            task: {
                type: Object,
                required: true
            },
            draggable: {
                type: Boolean,
                required: false
            },
            completed: {
                type: Boolean,
                required: false
            }
        },
        mixins: [TaskHelper]
    }
</script>
