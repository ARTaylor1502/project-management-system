<template>
    <div class="row w-100">
        <div v-if="total_tasks > 0" class="col-md-6 row">
            <div class="col-xs-2 mr-3">
                <div class="donut-chart">
                    <div class="slice one"></div>
                    <div class="slice two"></div>
                    <div class="chart-center">
                        <span></span>
                    </div>
                </div>
                <div id="task_time_spent_donut_chart" class="donut-chart" :style="{background: baseColor1}">
                    <div class="slice one" :style="{ transform: 'rotate('+ deg1+'deg)', background: color1}"></div>
                    <div class="slice two" :style="{ transform: 'rotate('+ deg2+'deg)', background: color2}"></div>
                    <div class="chart-center">
                        <span>{{tasks_completed_percentage}} %</span>
                    </div>
                </div>
            </div>
            <div class="col-xs-10">
                <h4 class="mb-0">Time Logged:</h4>
                <small>{{task_time_spent_hours}}hrs {{task_time_spent_minutes}}mins</small>
            </div>
        </div>
        <span v-else>No tasks found</span>
        <div v-if="total_tasks > 0" class="col-md-6 row">
            <div class="col-xs-2 mr-3">
                <div class="donut-chart">
                    <div class="slice one"></div>
                    <div class="slice two"></div>
                    <div class="chart-center">
                        <span></span>
                    </div>
                </div>
                <div id="tasks_completed_donut_chart" class="donut-chart" :style="{background: baseColor1}">
                    <div class="slice one" :style="{ transform: 'rotate('+ deg1+'deg)', background: color1}"></div>
                    <div class="slice two" :style="{ transform: 'rotate('+ deg2+'deg)', background: color2}"></div>
                    <div class="chart-center">
                        <span>{{tasks_completed_percentage}} %</span>
                    </div>
                </div>
            </div>
            <div class="col-xs-10">
                <h4 class="mb-0">Tasks:</h4>
                <small>{{tasks_completed}} of {{total_tasks}} Complete</small>
            </div>
        </div>
        <span v-else>No tasks found</span>
    </div>
</template>

<script>
    export default {
        name: "task-completion-chart",
        props: ['project'],
        data() {
            return {
                baseColor1: null,
                baseColor2: null,
                color1: null,
                color2: null,
                deg: 0,
                deg1: 0,
                deg2: 0,
                tasks_completed: 0,
                total_tasks: 0,
                tasks_completed_percentage: 0,
                task_time_spent_hours: 0,
                task_time_spent_minutes: 0
            }
        },
        mounted(){
            this.loadData();
            this.$eventHub.$on('tasks-updated', this.loadData);
        },
        methods: {
            loadData() {
                this.loadTotalTaskTimeSpent();
                this.loadTaskCompletionData();
            },
            loadTotalTaskTimeSpent() {
                axios.get(this.$route('api.project.task.time.spent', this.project.id))
                .then(response => {
                    this.task_time_spent_hours = response.data.hours;
                    this.task_time_spent_minutes = response.data.minutes;
                }).catch(error => {
                    console.log(error);
                });
            },
            loadTaskCompletionData() {
                axios.get(this.$route('api.project.task.completion', this.project.id))
                .then(response => {
                    this.tasks_completed = response.data.completed;
                    this.total_tasks = response.data.total;
                    this.tasks_completed_percentage = response.data.completion_percentage;
                    this.deg = (this.tasks_completed_percentage/100)*360;
                    this.baseColor1 = '#e1e1e1';
                    this.baseColor2 = '#e1e1e1';
                    this.color1 = '#53BC71';
                    this.color2 = '#53BC71';

                    if(this.tasks_completed_percentage < 50) {
                        this.baseColor1 = this.color1;
                        this.color1 = this.baseColor2;
                        this.color2 = this.baseColor2;
                        this.deg1 = (this.tasks_completed_percentage/100)*360+90;
                        this.deg2 = 0;
                    } else {
                        this.deg1 = 90;
                        this.deg2 = this.deg;
                    }
                }).catch(error => {
                    console.log(error);
                });
            }
        }
    }
</script>
