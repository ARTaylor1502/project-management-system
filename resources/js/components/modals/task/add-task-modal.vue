<template>
    <modal @close-modal="closeModal">
        <template slot="header">Add new task</template>
        <template slot="body">
            <form @submit.prevent="addNewTaskTaskHandler()">
                <template v-if="available_staff.length > 0">
                    <div class="form-group">
                        <label for="new_task_name" class="col-form-label">Name:</label>
                        <input type="text" class="form-control" id="new_task_name" name="new_task_name" v-model="form_data.name">
                        <ul v-if="errors.name" class="error-list">
                            <li v-for="error in errors.name">{{error}}</li>
                        </ul>
                    </div>
                    <div class="form-group">
                        <label for="new_task_staff" class="col-form-label">Staff Member:</label>
                        <select id="new_task_staff" name="new_task_staff" class="form-control" v-model="form_data.user_id">
                            <option v-for="staff_member in available_staff" :value="staff_member.id">{{staff_member.first_name}} {{staff_member.last_name}}</option>
                        </select>
                        <ul v-if="errors.user_id" class="error-list">
                            <li v-for="error in errors.user_id">{{error}}</li>
                        </ul>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="new_task_start_date_temp" class="col-form-label">Start Date:</label>
                            <input type="date" class="form-control" id="new_task_start_date_temp" name="new_task_start_date_temp" v-model="start_date_temp">
                            <ul v-if="errors.start_date" class="error-list">
                                <li v-for="error in errors.start_date">{{error}}</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <label for="new_task_start_time" class="col-form-label">Start Time:</label>
                            <input type="time" class="form-control" id="new_task_start_time" name="new_task_start_time" required v-model="start_time">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="new_task_due_date_temp" class="col-form-label">Due Date:</label>
                            <input type="date" class="form-control" id="new_task_due_date_temp" name="new_task_due_date_temp" v-model="due_date_temp">
                            <ul v-if="errors.due_date" class="error-list">
                                <li v-for="error in errors.due_date">{{error}}</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <label for="new_task_due_time" class="col-form-label">Due Time:</label>
                            <input type="time" class="form-control" id="new_task_due_time" name="new_task_due_time" required v-model="due_time">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="new_task_task_notes" class="col-form-label">Notes:</label>
                        <textarea id="new_task_task_notes" name="new_task_task_notes" class="form-control" v-model="form_data.notes"></textarea>
                        <ul v-if="errors.notes" class="error-list">
                            <li v-for="error in errors.notes">{{error}}</li>
                        </ul>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="new_task_quote_required">Quote Required?</label>
                        <input type="checkbox" id="new_task_quote_required" name="new_task_quote_required" v-model="form_data.quote_required"/>
                        <ul v-if="errors['quote_required']" class="error-list">
                            <li v-for="error in errors['quote_required']">{{error}}</li>
                        </ul>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Add Task <i class="fal fa-plus"></i></button>
                    </div>
                </template>
                <p v-else>Please assign staff to the project</p>
            </form>
        </template>
    </modal>
</template>

<script>
    import modal from '../../modal';
    import TaskHelper from '../../../components/mixins/task-helper'

    export default {
        name: "add-task-modal",
        components: {
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
            }
        },
        data() {
            return {
                errors: {},
                available_staff: [],
                form_data : {
                    position_index: 0,
                    project_id: this.project_id,
                    department_id: this.department_id,
                    custom_task_category_id: this.custom_task_category_id,
                    task_category_id: this.task_category_id,
                    quote_required: false,
                    user_id: false,
                    name: null,
                    start_date: null,
                    due_date: null,
                    noted: null
                },
                start_date_temp: null,
                start_time: null,
                due_date_temp: null,
                due_time: null
            }
        },
        created() {
            this.loadAvailableStaff();
            this.$eventHub.$on('add-task-errors', this.addTaskErrorsHandler);
        },
        computed: {
            start_date() {
                return this.start_date_temp + ' ' + this.start_time;
            },
            due_date() {
                return this.due_date_temp + ' ' + this.due_time;
            }
        },
        methods: {
            addTaskErrorsHandler(errors) {
                this.errors = errors;
            },
            addNewTaskTaskHandler() {
                this.form_data.start_date = this.start_date;
                this.form_data.due_date = this.due_date;

                this.addNewTask(this.form_data);
            },
            loadAvailableStaff() {
                let self = this;

                axios.get(this.$route('api.project.available.users', this.project_id))
                .then(response => {
                    response.data.forEach(function(user) {
                        self.available_staff.push(user);
                    });

                    if(self.available_staff.length > 0) {
                        self.form_data.user_id = self.available_staff[0].id;
                    }
                })
                .catch(error => {
                    console.log(error);
                });
            },
            closeModal() {
                this.$emit('add-task-modal-closed');
            }
        }
    }
</script>
