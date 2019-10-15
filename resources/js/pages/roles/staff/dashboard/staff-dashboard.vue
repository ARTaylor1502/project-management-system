<template>
    <div>
        <user-projects :staff_id="staff_id">
            <template slot="heading">
                <a :href="'/projects/user/' + staff_id" class="float-right">See all projects <i class="fal fa-arrow-right"></i></a>
                <h2>My Projects</h2>
            </template>
        </user-projects>
        <div class="row mt-5">
            <div class="col-md-7">
                <h2>My Calendar</h2>
                <staff-calendar :user="user" :user_projects="projects"></staff-calendar>
            </div>
            <div class="col-md-5">
                <h2>My Tasks</h2>
                <div class="card">
                    <div class="card-header">
                        <img v-if="user.avatar" class="avatar" :src="user.avatar" alt="Logo" :title="user.full_name">
                        <span v-else class="avatar-placeholder" :title="user.full_name">
                            <i class="fal fa-user"></i>
                        </span>
                    </div>
                    <div class="card-body">
                        <user-tasks :staff_id="staff_id"></user-tasks>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import UserProjects from './user-projects'
    import UserTasks from './user-tasks'
    import StaffCalendar from './staff-calendar'
    import UserHelper from '../../../../components/mixins/user-helper'

    export default {
        name: "staff-dashboard",
        components: {
            StaffCalendar,
            UserProjects,
            UserTasks
        },
        mixins: [UserHelper],
        props: ['staff_id'],
        created() {
            this.loadUser(this.staff_id);
            this.loadUserProjects(this.staff_id);
        }
    }
</script>
