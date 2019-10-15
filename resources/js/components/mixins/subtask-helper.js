export default {
    data() {
        return {
            subtasks: []
        }
    },
    computed: {
        active_subtasks() {
            return this.subtasks.filter(function(task) {
                return task.completed === 0;
            });
        },
        completed_subtasks() {
            return this.subtasks.filter(function(task) {
                return task.completed === 1;
            });
        }
    },
    methods: {
        addSubtask(task_data) {
            let self = this;

            axios.post(this.$route('api.task.store.subtask'), task_data)
            .then(response => {
                if(response.data.status === 'success') {
                    self.$eventHub.$emit('new-subtask-added', response.data.subtask.id);
                } else if(response.data.status === 'error') {
                    self.$eventHub.$emit('new-subtask-added-errors', response.data.errors);
                }
            }).catch(function (error) {
                if(error.response) {
                    console.log(error.response.data.errors);
                }
            });
        },
        loadSubTasks(task_id) {
            let self = this;

            axios.get(this.$route('api.task.subtasks', task_id))
            .then(response => {
                self.subtasks = [];

                response.data.forEach(function(subtask) {
                    self.subtasks.push(subtask);
                });

                self.$eventHub.$emit('subtasks-count', self.subtasks.length);
            }).catch(function (error) {
                console.log(error);
            });
        },
        markSubtaskComplete(subtask_id) {
            let self = this;

            axios.post(this.$route('api.task.subtask.mark.complete'), {subtask_id: subtask_id})
            .then(response => {
                if(response.data.status === 'success') {
                    self.$eventHub.$emit('subtask-completed');
                } else if(response.data.status === 'error') {
                    console.log(response.data.errors);
                }
            }).catch(function (error) {
                if(error.response) {
                    console.log(error.response.data.errors);
                }
            });
        }
    }
}
