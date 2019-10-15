<template>
    <div class="card">
        <div class="tasks-container active-tasks-container card-body">
            <h3 class="mb-3">Active</h3>
            <draggable v-if="active_tasks.length > 0" :list="active_tasks" :animation="200" :tag="'div'" @change="updateActiveTasksOrder" class="list active-tasks tasks scrollable-list">
                <task-list-item v-for="task in active_tasks" v-bind:key="task.id" :draggable="true" :task="task" class="list-item task">
                    <template slot="task-name">
                        <span class="task-name text-truncate">{{task.name}}</span>
                        <span class="due-date col-md-3" :class="task.overdue? 'overdue' : 'due'">- Due {{task.due_date_formatted}}</span>
                    </template>
                    <template slot="right-container">
                        <button class="btn btn-sm btn-primary pl-3 pr-3 mr-3 edit" @click="editTaskHandler(task)">Edit</button>
                        <span>Assigned to {{task.user.first_name}}</span>
                        <img v-if="task.user.avatar_path" class="avatar" :src="task.user.avatar_path"/>
                        <span v-else :title="task.user.full_name" class="avatar-placeholder avatar user-logo-container ml-3">
                            <i class="fal fa-user"></i>
                        </span>
                    </template>
                </task-list-item>
            </draggable>
            <p v-else>No active tasks found</p>
            <button class="btn primary-custom" @click="addTaskModalActive = true">Add New Task <i class="fal fa-plus"></i></button>
        </div>
        <div class="tasks-container completed-tasks-container card-footer">
            <h3 class="mb-3">Complete</h3>
            <div v-if="completed_tasks.length > 0" class="list active-tasks tasks scrollable-list">
                <task-list-item v-for="task in completed_tasks" v-bind:key="task.id" :draggable="false" :completed="true" :task="task" class="list-item task">
                    <template slot="task-name">
                        <span class="task-name text-truncate">{{task.name}}</span>
                        <span class="due-date col-md-3">- Completed {{task.completed_date_formatted}}</span>
                    </template>
                    <template slot="right-container">
                        <span>Assigned to {{task.user.first_name}}</span>
                        <img v-if="task.user.avatar_path" class="avatar" :src="task.user.avatar_path"/>
                        <span v-else :title="task.user.full_name" class="avatar-placeholder avatar user-logo-container ml-3">
                            <i class="fal fa-user"></i>
                        </span>
                    </template>
                </task-list-item>
            </div>
            <p v-else>No completed tasks found</p>
        </div>
        <add-task-modal v-show="addTaskModalActive"
                        :project_id="project_id"
                        :department_id="department_id"
                        :custom_task_category_id="custom_task_category_id"
                        :task_category_id="task_category_id"
                        @add-task-modal-closed="addTaskModalActive = false">
        </add-task-modal>
        <edit-task-modal v-if="editTaskModalActive"
                         :project_id="project_id"
                         :department_id="department_id"
                         :existing_task="selected_task"
                         :user_id="user_id"
                         @edit-task-modal-closed="editTaskModalActive = false">
        </edit-task-modal>
        <delete-task-modal v-if="deleteTaskModalActive"
                           :task_id="selected_task.id"
                           @delete-task-modal-closed="deleteTaskModalActive = false">
        </delete-task-modal>
        <modal v-show="successModalActive"
               @close-modal="successModalActive = false">
            <template slot="header">Success</template>
            <template slot="body">{{successBodyContent}}</template>
        </modal>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'
    import AddTaskModal from '../../components/modals/task/add-task-modal'
    import EditTaskModal from '../modals/task/edit/edit-task-modal'
    import TaskHelper from '../../components/mixins/task-helper'
    import DeleteTaskModal from '../modals/task/edit/delete-task-modal';
    import modal from '../modal'

    export default {
        components : {
            draggable,
            AddTaskModal,
            EditTaskModal,
            DeleteTaskModal,
            TaskHelper,
            modal
        },
        mixins: [TaskHelper],
        props: {
            project_id: {
                type: Number,
                required: true
            },
            custom_task_category_id: {
                type: Number,
                required: false
            },
            task_category_id: {
                type: Number,
                required: false
            },
            department_id: {
                type: Number,
                required: true
            },
            user_id: {
                type: Number,
                required: true
            }
        },
        data() {
            return {
                addTaskModalActive: false,
                editTaskModalActive: false,
                selected_task: false,
                successModalActive: false,
                deleteTaskModalActive: false,
                successBodyContent: ''
            }
        },
        created() {
            this.loadTasks();
            this.$eventHub.$on('new-task-added', this.taskAddedHandler);
            this.$eventHub.$on('task-updated', this.taskUpdatedHandler);
            this.$eventHub.$on('task-completed', this.taskCompletedHandler);
            this.$eventHub.$on('task-deleted', this.taskDeletedHandler);
            this.$eventHub.$on('activate-delete-modal', this.activateDeleteModalHandler);
        },
        methods: {
            loadTasks() {
                if(this.task_category_id !== undefined) {
                    this.loadProjectTaskCategoryTasks(this.project_id, this.task_category_id);
                } else if (this.custom_task_category_id !== undefined) {
                    this.loadProjectCustomTaskCategoryTasks(this.project_id, this.custom_task_category_id);
                } else {
                    this.loadProjectDepartmentTasks(this.project_id, this.department_id);
                }
            },
            editTaskHandler(task) {
                this.selected_task = task;
                this.editTaskModalActive = true;
            },
            taskDeletedHandler(message) {
                this.deleteTaskModalActive = false;
                this.editTaskModalActive = false;
                this.loadProjectDepartmentTasks(this.project_id, this.department_id);
                this.showSuccessModal(message);
            },
            taskAddedHandler(e) {
                this.loadTasks();
                this.addTaskModalActive = false;
                this.showSuccessModal(e.message);
            },
            taskUpdatedHandler(e) {
                this.editTaskModalActive = false;
                this.showSuccessModal(e.message);
                this.loadTasks();
            },
            showSuccessModal(message) {
                this.successBodyContent = message;
                this.successModalActive = true;
            },
            activateDeleteModalHandler() {
                this.deleteTaskModalActive = true;
            },
            taskCompletedHandler() {
                this.loadTasks();
                this.updateActiveTasksOrder();
            }
        }
    }
</script>
