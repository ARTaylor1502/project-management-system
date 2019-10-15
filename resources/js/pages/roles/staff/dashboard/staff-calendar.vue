<template>
    <div class="card">
        <div class="card-header border-bottom-0 pb-0 mb-0 d-flex">
            <img v-if="user.avatar" class="avatar" :src="user.avatar" alt="Logo" :title="user.full_name">
            <span v-else class="avatar-placeholder" :title="user.full_name">
               <i class="fal fa-user"></i>
            </span>
            <v-menu bottom right>
                <template v-slot:activator="{ on }">
                    <v-btn
                        class="ml-auto"
                        outlined
                        v-on="on">
                        <span>{{ typeToLabel[type] }}</span>
                        <span class="d-flex flex-column ml-3">
                            <i class="fas fa-sort-up"></i>
                            <i class="fas fa-sort-down"></i>
                        </span>
                    </v-btn>
                </template>
                <v-list>
                    <v-list-item @click="type = 'day'">
                        <v-list-item-title>Day</v-list-item-title>
                    </v-list-item>
                    <v-list-item @click="type = 'week'">
                        <v-list-item-title>Week</v-list-item-title>
                    </v-list-item>
                    <v-list-item @click="type = 'month'">
                        <v-list-item-title>Month</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
        </div>
        <div class="card-body">
            <v-sheet class="custom-calendar">
                <div class="month-header d-flex justify-content-between p-3 align-items-center">
                    <i class="fal fa-arrow-left" @click="prev"></i>
                    <v-toolbar-title>{{ title }}</v-toolbar-title>
                    <i class="fal fa-arrow-right" @click="next"></i>
                </div>
                <v-calendar
                    ref="calendar"
                    v-model="focus"
                    color="primary"
                    :events="events"
                    :event-color="getEventColor"
                    :event-margin-bottom="3"
                    :now="today"
                    :type="type"
                    :weekdays="weekdays"
                    @click:event="showEvent"
                    @click:more="viewDay"
                    @click:date="viewDay"
                    @change="updateRange">
                </v-calendar>
                <!--v-menu
                    v-model="selectedOpen"
                    :close-on-content-click="false"
                    :activator="selectedElement"
                    full-width
                    offset-x>
                    <v-card
                        color="grey lighten-4"
                        min-width="350px"
                        flat>
                        <v-toolbar
                            :color="selectedEvent.color"
                            dark>
                            <v-btn icon>
                                <v-icon>mdi-pencil</v-icon>
                            </v-btn>
                            <v-toolbar-title v-html="selectedEvent.name"></v-toolbar-title>
                            <div class="flex-grow-1"></div>
                            <v-btn icon>
                                <v-icon>mdi-heart</v-icon>
                            </v-btn>
                            <v-btn icon>
                                <v-icon>mdi-dots-vertical</v-icon>
                            </v-btn>
                        </v-toolbar>
                        <v-card-text>
                            <span v-html="selectedEvent.details"></span>
                        </v-card-text>
                        <v-card-actions>
                            <v-btn
                                text
                                color="secondary"
                                @click="selectedOpen = false">
                                Cancel
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-menu-->
            </v-sheet>
        </div>
    </div>
</template>

<script>
    export default {
        name: "staff-calendar",
        props: ['user', 'user_projects'],
        data() {
            return {
                today: this.todaysDateFormatted(),
                focus: this.todaysDateFormatted(),
                type: 'month',
                typeToLabel: {
                    month: 'Month',
                    week: 'Week',
                    day: 'Day'
                },
                start: null,
                end: null,
                selectedEvent: {},
                selectedElement: null,
                selectedOpen: false,
                weekdays: [1,2,3,4,5,6,0]
            }
        },
        computed: {
            title() {
                const { start, end } = this;
                if (!start || !end) {
                    return ''
                }

                const startMonth = this.monthFormatter(start);
                const endMonth = this.monthFormatter(end);

                const startYear = start.year;
                const endYear = end.year;

                const startDay = start.day + this.nth(start.day);
                const endDay = end.day + this.nth(end.day);

                switch (this.type) {
                    case 'month':
                        return `${startMonth} ${startYear}`;
                    case 'week':
                        return `${startDay} ${startMonth} ${startYear} - ${endDay} ${endMonth} ${endYear}`;
                    case 'day':
                        return `${startDay} ${startMonth} ${startYear}`
                }

                return '';
            },
            events() {
                let projects = [];

                this.user_projects.forEach(function (project) {
                    let start_date = new Date(project.event.start_date);
                    let end_date = new Date(project.event.end_date);
                    let start_date_formatted = start_date.getFullYear() + '-' + (start_date.getMonth()+1) + '-' +  start_date.getDate() + ' ' + start_date.getHours() + ":" + start_date.getMinutes();
                    let end_date_formatted = end_date.getFullYear() + '-' + (end_date.getMonth()+1) + '-' +  end_date.getDate() + ' ' + end_date.getHours() + ":" + end_date.getMinutes();

                    projects.push({
                        name: project.name,
                        start: start_date_formatted,
                        end: end_date_formatted,
                        color: '#D55959'
                    });
                });

                return projects;
            },
            monthFormatter () {
                return this.$refs.calendar.getFormatter({
                    timeZone: 'UTC', month: 'long',
                });
            },
        },
        mounted () {
            this.$refs.calendar.checkChange()
        },
        methods: {
            todaysDateFormatted() {
                let today = new Date();

                return today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
            },
            viewDay ({ date }) {
                this.focus = date
                this.type = 'day'
            },
            getEventColor (event) {
                return event.color
            },
            prev () {
                this.$refs.calendar.prev()
            },
            next () {
                this.$refs.calendar.next()
            },
            showEvent ({ nativeEvent, event }) {
                const open = () => {
                    this.selectedEvent = event
                    this.selectedElement = nativeEvent.target
                    setTimeout(() => this.selectedOpen = true, 10)
                }

                if (this.selectedOpen) {
                    this.selectedOpen = false
                    setTimeout(open, 10)
                } else {
                    open()
                }

                nativeEvent.stopPropagation()
            },
            updateRange ({ start, end }) {
                // You could load events from an outside source (like database) now that we have the start and end dates on the calendar
                this.start = start;
                this.end = end;
            },
            nth (d) {
                return d > 3 && d < 21
                    ? 'th'
                    : ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'][d % 10]
            },
        }
    }
</script>
