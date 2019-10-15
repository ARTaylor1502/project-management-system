<template>
    <modal @close-modal="closeModal">
        <template slot="header">Delete Task</template>
        <template slot="body">
            <p>Are you sure you wish to delete this task?</p>
            <div class="text-center mt-5">
                <button class="btn btn-lg btn-primary mr-2" @click="deleteTask(task_id)">Yes</button>
                <button class="btn btn-lg btn-secondary" @click="closeModal">No</button>
            </div>
        </template>
    </modal>
</template>

<script>
    import modal from '../../../modal';
    import TaskHelper from '../../../../components/mixins/task-helper';

    export default {
        name: "delete-task-modal",
        props: ['task_id'],
        components: {
            modal
        },
        mixins: [TaskHelper],
        data() {
            return {
                errors: {}
            }
        },
        methods: {
            closeModal() {
                this.$emit('delete-task-modal-closed');
            }
        }
    }
</script>
