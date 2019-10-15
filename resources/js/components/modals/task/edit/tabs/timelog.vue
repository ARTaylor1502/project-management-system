<template>
    <div>
        <div class="modal-body">
            <template v-for="timelog in timelogs">
                <div class="mb-3 timelog">
                    <div class="d-flex mb-3">
                        <h3 class="mr-auto mb-0 align-self-center">{{timelog.hours}}hrs {{timelog.minutes}}mins</h3>
                        <div class="timelog-user-container d-flex">
                            <span class="mr-3 align-self-center">By {{timelog.user.full_name}}</span>
                            <img v-if="timelog.user.avatar" class="avatar" :src="timelog.user.avatar" :alt="timelog.user.full_name" :title="timelog.user.full_name">
                            <i v-if="!timelog.user.avatar" class="avatar-placeholder fal fa-user" :title="timelog.user.full_name"></i>
                        </div>
                    </div>
                    <h4 class="mb-3">{{timelog.created_date_formatted}} at {{timelog.created_time_formatted}}</h4>
                    <p class="mb-0">{{timelog.notes}}</p>
                </div>
            </template>
            <button class="btn primary-custom full-width" @click="addTimelogModalActive = true">Submit Time <i class="fal fa-plus"></i></button>
        </div>
        <div class="timelog-total">
            <span class="subtitle">Total: </span><span>{{timelogHoursTotal}}hrs {{timelogMinutesTotal}}mins</span>
        </div>
        <add-timelog-modal v-if="addTimelogModalActive"
                           :task_id="task_id"
                           :user_id="user_id"
                           @add-timelog-modal-closed="addTimelogModalActive = false">
        </add-timelog-modal>
        <modal v-show="successModalActive === true"
               @close-modal="successModalActive = false">
            <template slot="header">Success</template>
            <template slot="body">{{successBodyContent}}</template>
        </modal>
    </div>
</template>

<script>
    import AddTimelogModal from '../add-timelog-modal'
    import modal from '../../../../modal';

    export default {
        name: "timelog",
        props: ['task_id', 'user_id'],
        components: {
            AddTimelogModal,
            modal
        },
        data() {
            return {
                timelogs: [],
                addTimelogModalActive: false,
                successModalActive: false,
                successBodyContent: ''
            }
        },
        created() {
            this.getTaskTimelogs(this.task_id);
            this.$eventHub.$on('new-timelog-added', this.newTimelogAddedHandler);
        },
        computed: {
            timelogHoursTotal() {
                let hours = 0;

                this.timelogs.forEach(function (timelog) {
                    hours += timelog.hours;
                });

                return hours + this.totalCalculatedHoursFromMinutesTally;
            },
            totalCalculatedHoursFromMinutesTally() {
                let minutes = 0;

                this.timelogs.forEach(function (timelog) {
                    minutes += timelog.minutes;
                });

                return Math.floor(minutes / 60);
            },
            timelogMinutesTotal() {
                let minutes = 0;

                this.timelogs.forEach(function (timelog) {
                    minutes += timelog.minutes;
                });

                return minutes % 60;
            }
        },
        methods: {
            getTaskTimelogs(task_id) {
                let self = this;

                axios.get(this.$route('api.task.timelog.list', task_id))
                .then(response => {
                    self.timelogs = [];

                    response.data.forEach(function(log) {
                        self.timelogs.push(log);
                    });
                }).catch(function (error) {
                    console.log(error);
                });
            },
            newTimelogAddedHandler(e) {
                this.getTaskTimelogs(this.task_id);
                this.addTimelogModalActive = false;
                this.showSuccessModal(e.message);
            },
            showSuccessModal(message) {
                this.successBodyContent = message;
                this.successModalActive = true;
            }
        }
    }
</script>
