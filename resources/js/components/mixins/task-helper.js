export default {
    data() {
        return {
            tasks: [],
            task_lists: [],
            addTaskModalActive: false
        }
    },
    computed: {
        active_tasks() {
            return this.tasks.filter(function (task) {
                return task.completed === 0;
            });
        },
        completed_tasks() {
            return this.tasks.filter(function (task) {
                return task.completed === 1;
            });
        },
    },
    methods: {
        addNewTask(task) {
            let self = this;

            axios.post(this.$route('api.task.store'), task)
            .then(response => {
                if(response.data.status === 'success') {
                    self.$eventHub.$emit('new-task-added', {message: response.data.message, task: response.data.task});
                } else if(response.data.status === 'error') {
                    self.$eventHub.$emit('add-task-errors', response.data.errors);
                }
            })
            .catch(error => {
                console.log(error);
            });
        },
        update_task(task_id, task_data) {
            let self = this;

            axios.put(this.$route('api.task.update', task_id), task_data)
            .then(response => {
                if(response.data.status === 'success') {
                    self.$eventHub.$emit('task-updated', {message: response.data.message, task: response.data.task});
                } else if(response.data.status === 'error') {
                    self.$eventHub.$emit('update-task-errors', response.data.errors);
                }
            })
            .catch(error => {
                console.log(error);
            });
        },
        add_task_files(task_id, files) {
            let self = this;

            axios.post(this.$route('api.task.add.files', task_id), files, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                if(response.data.status === 'success') {
                    //self.$eventHub.$emit('task-updated', {message: response.data.message, task: response.data.task});
                } else if(response.data.status === 'error') {
                    self.$eventHub.$emit('update-task-errors', response.data.errors);
                }
            })
            .catch(error => {
                console.log(error);
            });
        },
        loadProjectDepartmentTasks(project_id, department_id) {
            axios.get(this.$route('api.task.project.department.tasks', project_id, department_id))
            .then(response => {
                this.tasks = [];
                response.data.forEach((task) => {
                    this.tasks.push(task);
                });
                this.$eventHub.$emit('tasks-updated');
            }).catch(function (error) {
                console.log(error);
            });
        },
        loadProjectTaskCategoryTasks(project_id, task_category_id) {
            axios.get(this.$route('api.task.project.task-category.tasks', project_id, task_category_id))
            .then(response => {
                this.tasks = [];
                response.data.forEach((task) => {
                    this.tasks.push(task);
                });
                this.$eventHub.$emit('tasks-updated');
            }).catch(function (error) {
                console.log(error);
            });
        },
        loadProjectCustomTaskCategoryTasks(project_id, custom_task_category_id) {
            axios.get(this.$route('api.task.project.custom-task-category.tasks', project_id, custom_task_category_id))
            .then(response => {
                this.tasks = [];
                response.data.forEach((task) => {
                    this.tasks.push(task);
                });
                this.$eventHub.$emit('tasks-updated');
            }).catch(function (error) {
                console.log(error);
            });
        },
        updateActiveTasksOrder() {
            this.active_tasks.map((task, index) => {
                task.position_index = index + 1;
            });

            axios.put(this.$route('api.task.update.tasks.order'), {tasks: this.active_tasks})
            .catch(function (error) {
                console.log(error);
            });
        },
        markTaskCompleted(task_id) {
            axios.put(this.$route('api.task.mark.complete'), {task_id: task_id})
            .then(response => {
                if(response.data.status === 'success') {
                    this.$eventHub.$emit('task-completed');
                }
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        deleteTask(task_id) {
            let self = this;

            axios.post(this.$route('api.task.delete'), {task_id: task_id})
            .then(response => {
                if(response.data.status === 'success') {
                    self.$eventHub.$emit('task-deleted', response.data.message);
                } else if(response.data.status === 'error') {
                    self.$eventHub.$emit('task-deletion-errors', response.data.errors);
                }
            })
            .catch(error => {
                console.log(error);
            });
        }
    }
}
