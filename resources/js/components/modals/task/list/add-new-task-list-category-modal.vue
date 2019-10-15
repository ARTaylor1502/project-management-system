<template>
    <modal @close-modal="closeModal">
        <template slot="header">Add new task list category</template>
        <template slot="body">
            <form @submit.prevent="addNewTaskListCategory(form_data)">
                <div class="form-group">
                    <label for="new_tasklist_category" class="col-form-label">Category Name:</label>
                    <input type="text" class="form-control" id="new_tasklist_category" name="new_tasklist_category" v-model="form_data.name">
                    <ul v-if="errors.name" class="error-list">
                        <li v-for="error in errors.name">{{error}}</li>
                    </ul>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Add New Category <i class="fal fa-plus"></i></button>
                </div>
            </form>
        </template>
    </modal>
</template>

<script>
    import modal from '../../../modal'

    export default {
        name: "add-new-task-list-modal",
        components: {
            modal
        },
        props: ['project_id', 'department_id'],
        data() {
            return {
                errors: {},
                form_data : {
                    project_id: this.project_id,
                    department_id: this.department_id,
                    name: ''
                },
            }
        },
        methods: {
            addNewTaskListCategory() {
                let self = this;

                axios.post(this.$route('api.task.store.project.task.category'), this.form_data)
                .then(response => {
                    if(response.data.status === 'success') {
                        self.$emit('new-tasklist-category-added', response.data);
                    } else if(response.data.status === 'error') {
                        self.errors = response.data.errors;
                    }
                })
                .catch(error => {
                    console.log(error);
                });
            },
            closeModal() {
                this.$emit('add-new-task-list-category-modal-closed');
            }
        }
    }
</script>
