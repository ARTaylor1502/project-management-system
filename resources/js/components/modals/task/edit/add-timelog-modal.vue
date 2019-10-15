<template>
    <modal @close-modal="closeModal">
        <template slot="header">Add Timelog</template>
        <template slot="body">
            <div class="form-group">
                <label for="add_timelog_note" class="col-form-label">Notes:</label>
                <textarea class="form-control" id="add_timelog_note" name="add_timelog_note" v-model="newTimeLogData.notes"></textarea>
                <ul v-if="errors.notes" class="error-list">
                    <li v-for="error in errors.notes">{{error}}</li>
                </ul>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <label for="add_timelog_hours" class="col-form-label">Hours:</label>
                    <input class="form-control" id="add_timelog_hours" min="0" name="add_timelog_hours" placeholder="Hours" type="number" v-model="newTimeLogData.hours">
                    <ul v-if="errors.hours" class="error-list">
                        <li v-for="error in errors.hours">{{error}}</li>
                    </ul>
                </div>
                <div class="col-sm-6">
                    <label for="add_timelog_minutes" class="col-form-label">Minutes:</label>
                    <input class="form-control" id="add_timelog_minutes" min="0" max="59" name="add_timelog_minutes" placeholder="Minutes" type="number" v-model="newTimeLogData.minutes">
                    <ul v-if="errors.minutes" class="error-list">
                        <li v-for="error in errors.minutes">{{error}}</li>
                    </ul>
                </div>
            </div>
            <div class="text-center">
                <button class="btn btn-primary" @click="addTimelog">Add</button>
            </div>
        </template>
    </modal>
</template>

<script>
    import modal from '../../../modal';

    export default {
        name: "add-timelog-modal",
        props: ['task_id', 'user_id'],
        components: {
            modal
        },
        data() {
          return {
              newTimeLogData: {
                task_id: this.task_id,
                user_id: this.user_id,
                notes: '',
                hours: 0,
                minutes: 0
              },
              errors: {}
          }
        },
        methods: {
            addTimelog() {
                let self = this;

                axios.post(this.$route('api.task.timelog.store'), this.newTimeLogData)
                .then(response => {
                    if(response.data.status === 'success') {
                        self.$eventHub.$emit('new-timelog-added', {message: response.data.message, timelog: response.data.timelog});
                    } else if(response.data.status === 'error') {
                        self.errors = response.data.errors;
                    }
                })
                .catch(error => {
                    console.log(error);
                });
            },
            closeModal() {
                this.$emit('add-timelog-modal-closed');
            }
        }
    }
</script>
