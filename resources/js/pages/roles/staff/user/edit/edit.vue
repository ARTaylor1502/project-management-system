<template>
    <div v-if="user">
        <h2>Summary</h2>
        <div class="card summary-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                        <h3>User Information</h3>
                        <ul>
                            <li>
                                <i class="fal fa-user-plus"></i>
                                <span>Date Added: {{user.created_at_formatted}}</span>
                            </li>
                            <li>
                                <i class="fal fa-edit"></i>
                                <span>Last Updated: {{user.updated_at_formatted}}</span>
                            </li>
                            <li>
                                <i class="fal fa-sign-in-alt"></i>
                                <span>Last Login: {{user.last_login_formatted ? user.last_login_formatted : 'N/A'}}</span>
                            </li>
                            <li>
                                <i class="fal fa-user-tag"></i>
                                <span>User Role: {{user.role.name}}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-4">
                        <h3>Contact Details</h3>
                        <ul>
                            <li>
                                <i class="fal fa-envelope"></i>
                                <span>{{user.email}}</span>
                            </li>
                            <li>
                                <i class="far fa-mobile-alt"></i>
                                <span>{{user.mobile_tele}}</span>
                            </li>
                            <li>
                                <i class="fas fa-phone"></i>
                                <span>{{user.landline_tele}}</span>
                            </li>
                            <li>
                                <i class="far fa-map-marker-alt"></i>
                                <span>{{user.primary_address ? user.primary_address : 'No primary adddress set'}}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-4">
                        <h3>Task Information</h3>
                        <ul>
                            <li>
                                <i class="far fa-tasks"></i>
                                <span>Current Tasks: {{user.active_tasks.length}}</span>
                            </li>
                            <li>
                                <i class="far fa-check-circle"></i>
                                <span>Tasks Completed: {{user.completed_tasks.length}}</span>
                            </li>
                            <li>
                                <i class="fal fa-stamp"></i>
                                <span>Artwork Approved: {{user.artwork_approved.length}}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row tabs-row">
            <div class="col-md-12">
                <tabs>
                    <tab name="Details" selected="true">
                        <details-tab :existing_user="user" :what3words_api_key="what3words_api_key"></details-tab>
                    </tab>
                    <tab name="Projects" :count="projects_count">
                        <projects-tab :user_id="user.id"></projects-tab>
                    </tab>
                </tabs>
            </div>
        </div>
    </div>
</template>

<script>
    import DetailsTab from './tabs/details-tab'
    import ProjectsTab from './tabs/projects-tab'
    import UserHelper from '../../../../../components/mixins/user-helper'

    export default {
        name: "edit",
        components: {
            DetailsTab,
            ProjectsTab
        },
        mixins: [UserHelper],
        props: ['user_id', 'what3words_api_key'],
        created() {
            this.loadUser(this.user_id);
            this.loadUserProjectsCount(this.user_id);
            this.$eventHub.$on('reload-user', this.reloadUser);
        },
        methods: {
            reloadUser() {
                this.loadUser(this.user_id);
            }
        }
    }
</script>
