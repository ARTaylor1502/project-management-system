<template>
    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="custom-modal-container">
                    <div class="inner-container">
                        <i class="fal fa-times close" @click="closeModal"></i>
                        <tabs>
                            <tab :name="'Details'" :selected="true" ref="details_tab">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="edit_task_name" class="col-form-label">Name of task:</label>
                                        <input type="text" class="form-control" id="edit_task_name" name="name" v-model="existing_task.name">
                                        <ul v-if="errors.name" class="error-list">
                                            <li v-for="error in errors.name">{{error}}</li>
                                        </ul>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_task_staff" class="col-form-label">Assigned to:</label>
                                        <select id="edit_task_staff" name="edit_task_staff" class="form-control" v-model="existing_task.user_id">
                                            <option v-for="staff_member in available_staff" :value="staff_member.id">{{staff_member.first_name}} {{staff_member.last_name}}</option>
                                        </select>
                                        <ul v-if="errors.user_id" class="error-list">
                                            <li v-for="error in errors.user_id">{{error}}</li>
                                        </ul>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="edit_task_start_date" class="col-form-label">Start Date:</label>
                                            <input type="date" class="form-control" id="edit_task_start_date" name="edit_task_start_date" v-model="existing_task.start_date_html_formatted">
                                            <ul v-if="errors.start_date" class="error-list">
                                                <li v-for="error in errors.start_date">{{error}}</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="edit_task_start_time" class="col-form-label">Start Time:</label>
                                            <input type="time" class="form-control" id="edit_task_start_time" name="edit_task_start_time" required v-model="existing_task.start_time_formatted">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="edit_task_due_date" class="col-form-label">Due Date:</label>
                                            <input type="date" class="form-control" id="edit_task_due_date" name="edit_task_due_date" v-model="existing_task.due_date_html_formatted">
                                            <ul v-if="errors.due_date" class="error-list">
                                                <li v-for="error in errors.due_date">{{error}}</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="edit_task_due_time" class="col-form-label">Due Time:</label>
                                            <input type="time" class="form-control" id="edit_task_due_time" name="edit_task_due_time" required v-model="existing_task.due_time_formatted">
                                        </div>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label for="edit_task_notes" class="col-form-label">Notes:</label>
                                        <textarea id="edit_task_notes" name="edit_task_notes" class="form-control" v-model="existing_task.notes"></textarea>
                                        <ul v-if="errors.notes" class="error-list">
                                            <li v-for="error in errors.notes">{{error}}</li>
                                        </ul>
                                    </div>
                                </div>
                                <div v-show="!subtasks_count > 0" class="full-width-divider">
                                    <pill-button @clicked="checklistActive = true">
                                        <template slot="button_text">Add Checklist</template>
                                        <template slot="cta_text"><i class="fal fa-plus"></i></template>
                                    </pill-button>
                                </div>
                            </tab>
                            <tab :name="'Attachments'">
                                <div class="modal-body">
                                    <tabs>
                                        <tab :name="'Existing Files'" :selected="true">
                                            <template v-if="existing_task.files.length > 0">
                                                <div class="list">
                                                    <div v-for="file in existing_task.files" class="list-item d-flex align-items-center mb-3">
                                                        <div class="mr-auto">{{file.name}}</div>
                                                        <a :href="file.src" download class="btn btn-primary btn-sm cta-item"><i class="fal fa-download"></i></a>
                                                    </div>
                                                </div>
                                            </template>
                                            <p v-else>No existing files found</p>
                                        </tab>
                                        <tab :name="'Add New'">
                                            <file-validator
                                                :is_multiple="true"
                                                :fileSelectorClasses="'col-md-12'"
                                                :filesFormatsAccepted="['doc', 'docx', 'gif', 'jpg', 'jpeg', 'pdf', 'png', 'xls', 'xlsx', 'zip']"
                                                :errorContainerClasses="'col-md-12 mt-4'">
                                                <template slot="button-text">Add New Attachment</template>
                                                <template slot="bottom-text">
                                                    <span class="caveat">Accepts: .doc, .docx, .gif, .jpg, .jpeg, .pdf, .png, .xls, .xlsx, .zip</span>
                                                    <span class="caveat">Maximum File Size: 24 MB</span>
                                                </template>
                                            </file-validator>
                                        </tab>
                                    </tabs>
                                </div>
                            </tab>
                            <tab :name="'Timelog'">
                                <timelog :task_id="existing_task.id"
                                         :user_id="user_id">
                                </timelog>
                            </tab>
                        </tabs>
                        <div class="modal-footer">
                            <div class="d-flex">
                                <button class="btn btn-delete"><i class="far fa-trash-alt" @click="$eventHub.$emit('activate-delete-modal')"></i></button>
                                <div class="ml-auto">
                                    <button class="btn btn-secondary mr-3" @click="closeModal">Cancel</button>
                                    <button class="btn btn-primary" @click="updateTaskHandler(existing_task.id, existing_task)">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                   <sub-tasks v-show="existing_task.id && subtasks_tab_active" :task_id="existing_task.id" :user_id="user_id"></sub-tasks>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    import modal from '../../../modal';
    import SubTasks from './subtasks';
    import TaskHelper from '../../../../components/mixins/task-helper';
    import Timelog from './tabs/timelog'

    export default {
        name: "edit-task-modal",
        components: {
            modal,
            SubTasks,
            Timelog
        },
        mixins: [TaskHelper],
        props: ['project_id', 'department_id', 'existing_task', 'user_id'],
        data() {
          return {
              errors: {},
              available_staff: [],
              update_task_data: {},
              subtasks_count: 0,
              checklistActive: false,
              files: null,
              fileFormData: new FormData()
          }
        },
        computed: {
            subtasks_tab_active() {
                return (this.subtasks_count > 0 || this.checklistActive) && this.$refs.details_tab.isActive;
            }
        },
        created() {
            this.loadProjectStaff();
            this.$eventHub.$on('files-validated', this.filesValidatedHandler);
            this.$eventHub.$on('subtasks-count', this.existingSubtasksHandler);
            this.$eventHub.$on('update-task-errors', this.updateTaskErrorsHandler);
        },
        methods: {
            existingSubtasksHandler(count) {
                this.subtasks_count = count;
            },
            updateTaskErrorsHandler(errors) {
                this.errors = errors;
            },
            updateTaskHandler() {
                this.populateFormData();
                this.update_task(this.existing_task.id, this.update_task_data);

                if(this.files !== null) {
                    this.populateFileFormData();
                    this.add_task_files(this.existing_task.id, this.fileFormData);
                }
            },
            filesValidatedHandler(files) {
                this.files = files;
            },
            populateFormData() {
                this.update_task_data = {
                    user_id: this.existing_task.user_id,
                    name: this.existing_task.name,
                    start_date: this.existing_task.start_date_html_formatted + ' ' + this.existing_task.start_time_formatted,
                    due_date: this.existing_task.due_date_html_formatted + ' ' + this.existing_task.due_time_formatted,
                    notes: this.existing_task.notes
                };
            },
            populateFileFormData() {
                if(this.files !== null) {
                    for(var i = 0; i < this.files.length; i++){
                        let file = this.files[i];
                        this.fileFormData.append('files[' + i + ']', file);
                    }
                }
            },
            loadProjectStaff() {
                let self = this;

                axios.get(this.$route('api.project.department.users', this.project_id, this.department_id))
                .then(response => {
                    self.available_staff = [];

                    response.data.forEach(function(user) {
                        self.available_staff.push(user);
                    });
                })
                .catch(error => {
                    console.log(error);
                });
            },
            closeModal() {
                this.$emit('edit-task-modal-closed');
            }
        }
    }
</script>

