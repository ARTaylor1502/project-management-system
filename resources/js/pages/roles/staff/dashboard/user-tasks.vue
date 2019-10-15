<template>
    <div>
        <div class="d-flex ml-5 mr-5 mb-5">
            <div class="ml-3 mr-3 info-container">
                <span class="mb-3 info-counter-container">
                    <span class="info-counter d-flex align-items-center justify-content-center">{{active_user_tasks_count}}</span>
                </span>
                <span class="text-center info-text">Tasks assigned to me</span>
            </div>
            <div class="ml-3 mr-3 info-container">
                 <span class="mb-3 info-counter-container">
                    <span class="info-counter d-flex align-items-center justify-content-center">{{weeks_completed_tasks_count}}</span>
                </span>
                <span class="text-center info-text">Tasks completed this week</span>
            </div>
            <div class="ml-3 mr-3 info-container">
                 <span class="mb-3 info-counter-container">
                    <span class="info-counter d-flex align-items-center justify-content-center">{{months_completed_tasks_count}}</span>
                </span>
                <span class="text-center info-text">Tasks completed this month</span>
            </div>
        </div>
        <div class="list tasks" v-for="task in active_tasks">
            <task-list-item :task="task">
                <template slot="task-name">
                    <h4 class="mb-0">{{task.name}}<br>
                        <span class="subtitle">{{task.project.name}} - {{task.project.client.name}}</span>
                    </h4>
                    <span class="ml-3"> - {{task.due_date_formatted}}</span>
                </template>
                <template slot="right-container">
                    <a :href="$route('staff.project.edit', task.project.id)"><i class="fal fa-arrow-right"></i></a>
                </template>
            </task-list-item>
        </div>
        <pagination v-if="number_of_pages > 1" class="mt-5" :pagesCount="number_of_pages" :currentPageNumber="page_number" @page-changed="pageChangedHandler"></pagination>
    </div>
</template>

<script>
    import UserHelper from '../../../../components/mixins/user-helper'
    import Pagination from '../../../../components/mixins/pagination'

    export default {
        name: "user-tasks",
        props: ['staff_id'],
        data() {
            return {
                active_tasks: [],
                months_completed_tasks_count: 0,
                weeks_completed_tasks_count: 0
            }
        },
        mixins: [UserHelper, Pagination],
        created() {
            this.loadActiveUserTasks(this.filters);
            this.loadCompletedTasksInLastMonth();
            this.loadCompletedTasksInLastWeek();
            this.$eventHub.$on('tasks-updated', this.tasksUpdatedHandler);
        },
        computed: {
            filters() {
                return {
                    page: this.page_number,
                    active: true,
                    items_per_page: 5
                }
            },
            active_user_tasks_count() {
                return this.total_items;
            },
            /*user_tasks_completed_this_week() {
                let today = new Date(), day = today.getDay() || 7;

                if(day !== 1) {
                    today.setHours(-24 * (day - 1));
                }

                return this.completed_tasks.filter(function (task) {
                    return new Date(task.completed_date) >= today;
                });
            },
            user_tasks_completed_this_month() {
                let date = new Date();let first_day_of_month = new Date(date.getFullYear(), date.getMonth(), 1);

                return this.completed_tasks.filter(function (task) {
                    return new Date(task.completed_date) >= first_day_of_month;
                });
            }*/
        },
        methods: {
            loadActiveUserTasks(filters) {
                let self = this, url = '/api/task/user/' + this.staff_id;

                if(filters !== undefined) {
                    let count = 0;

                    for (var key in filters) {
                        if (filters.hasOwnProperty(key)) {
                            if (filters[key]) {
                                if (count === 0) {
                                    url += '?';
                                } else {
                                    url += '&';
                                }
                                url += key + '=' + filters[key];
                            }

                            count++;
                        }
                    }
                }

                axios.get(url)
                .then(response => {
                    self.resetActiveTasks();

                    response.data.data.forEach(function(task) {
                        self.active_tasks.push(task);
                    });

                    self.updatePaginationInfo({ last_page: response.data.last_page, page_number: response.data.current_page, total_items_count: response.data.total});
                }).catch(function (error) {
                    console.log(error);
                });
            },
            resetActiveTasks() {
                this.active_tasks = [];
            },
            loadCompletedTasksInLastMonth() {
                let self = this;

                let today = new Date();
                let year = today.getFullYear();
                let month = (today.getMonth()+1);
                if(month < 10) {
                    month = '0' + month;
                }
                let first_day_of_current_month = + year + '-' + month + '-01';

                axios.get('/api/task/user/' + this.staff_id + '?completed=true&completed_date='+first_day_of_current_month + '&count=true')
                .then(response => {
                    self.months_completed_tasks_count = response.data;
                }).catch(function (error) {
                    console.log(error);
                });
            },
            loadCompletedTasksInLastWeek() {
                let self = this, today = new Date(), day = today.getDay() || 7;

                if(day !== 1) {
                    today.setHours(-24 * (day - 1));
                }

                if(day < 10) {
                    day = '0' + day;
                }

                let year = today.getFullYear();
                let month = (today.getMonth()+1);

                if(month < 10) {
                    month = '0' + month;
                }

                let first_day_of_current_week= + year + '-' + month + '-' + day;

                axios.get('/api/task/user/' + this.staff_id + '?completed=true&completed_date='+first_day_of_current_week + '&count=true')
                    .then(response => {
                        self.weeks_completed_tasks_count = response.data;
                    }).catch(function (error) {
                    console.log(error);
                });
            },
            tasksUpdatedHandler() {
                this.loadActiveUserTasks();
                this.loadCompletedTasksInLastMonth();
            },
            pageChangedHandler(page_number) {
                this.page_number = page_number;
                this.loadActiveUserTasks(this.filters);
            }
        }
    }
</script>
