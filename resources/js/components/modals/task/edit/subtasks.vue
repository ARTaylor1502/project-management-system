<template>
    <div class="subtasks">
        <div class="pill-search-container">
            <label for="pill_search" class="col-form-label">Subtasks</label>
            <div class="btn pill-search">
                <input id="pill_search" class="left-section" type="text" placeholder="Type to add new subtask" v-model="new_task.name"><span class="right-section"><i class="fal fa-plus" @click="addSubtask(new_task)"></i></span>
            </div>
        </div>
        <ul class="subtask-list mt-3 pl-0">
            <li v-for="task in active_subtasks" class="pb-3"><span class="tick-box-container mr-3" @click="markSubtaskComplete(task.id)"><i class="fal fa-square tick-base"><i class="fal fa-check tick-overlay"></i></i></span>{{task.name}}</li>
            <li v-for="task in completed_subtasks" class="pb-3 completed"><span class="tick-box-container completed mr-3"><i class="fal fa-square tick-base"><i class="fal fa-check tick-overlay"></i></i></span>{{task.name}}</li>
        </ul>
    </div>
</template>

<script>
    import SubTaskHelper from '../../../../components/mixins/subtask-helper'

    export default {
        name: "sub-tasks",
        props: ['task_id', 'user_id'],
        mixins: [SubTaskHelper],
        data() {
            return {
                new_task: {
                    task_id: this.task_id,
                    user_id: this.user_id,
                    name: '',
                    position_index: 0
                }
            }
        },
        created() {
            this.loadSubTasks(this.task_id);
            this.$eventHub.$on('new-subtask-added', this.newTaskAddedHandler);
            this.$eventHub.$on('subtask-completed', this.reloadSubTasks);
        },
        methods: {
            newTaskAddedHandler() {
                this.loadSubTasks(this.task_id)
            },
            reloadSubTasks() {
                this.loadSubTasks(this.task_id)
            }
        }
    }
</script>
