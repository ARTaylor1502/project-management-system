<template>
    <div>
        <div class="row row-eq-height">
            <project-summary v-if="project" :project="project"></project-summary>
            <project-status v-if="project" :project="project"></project-status>
            <team v-if="project" :project="project" :user="project.project_owner"></team>
        </div>
        <div class="row tabs-row" v-if="project">
            <div id="project_main_details" class="col-md-12">
                <tabs>
                    <tab name="Progress" v-bind:key="'Progress'" selected="true">
                        <tabs :classes="['card-header']">
                            <tab v-for="(department,index) in task_categories" v-bind:data="department" v-bind:key="department.name" :name="department.name" :selected="index === 0">
                                <template v-if="department.task_categories.length > 0">
                                    <tabs :classes="['subtabs']">
                                        <tab v-for="(task_category, index) in department.task_categories" v-bind:data="task_category" v-bind:key="task_category.name" :name="task_category.name" :selected="index === 0">
                                            <task-list :project_id="project.id" :task_category_id="task_category.category_id" :custom_task_category_id="task_category.custom_category_id" :department_id="department.id" :user_id="user_id"></task-list>
                                            <labour class="mt-5" v-if="department.name === 'Pre-Ops' && task_category.name === 'Labour'" :project_id="project.id"></labour>
                                            <accommodation class="mt-5" v-if="department.name === 'Pre-Ops' && task_category.name === 'Accommodation'" :project_id="project.id" :what3words_api_key="what3words_api_key"></accommodation>
                                            <transport class="mt-5" v-if="department.name === 'Pre-Ops' && task_category.name === 'Transport'" :project_id="project.id"></transport>
                                        </tab>
                                        <template slot="tab_additional">
                                            <pill-button @clicked="addNewTaskListModalCategoryActive = true">
                                                <template slot="button_text">Add</template>
                                                <template slot="cta_text"><i class="fal fa-plus"></i></template>
                                            </pill-button>
                                            <add-new-task-list-category-modal v-if="addNewTaskListModalCategoryActive"
                                                                     :project_id="project.id"
                                                                     :department_id="department.id"
                                                                     @new-tasklist-category-added="taskListCategoryAddedHandler"
                                                                     @add-new-task-list-category-modal-closed="addNewTaskListModalCategoryActive = false">
                                            </add-new-task-list-category-modal>
                                            <modal v-show="successModalActive"
                                                   @close-modal="successModalActive = false">
                                                <template slot="header">Success</template>
                                                <template slot="body">{{successBodyContent}}</template>
                                            </modal>
                                        </template>
                                    </tabs>
                                </template>
                                <task-list v-else :project_id="project.id" :department_id="department.id" :staff="project.users" :user_id="user_id"></task-list>
                            </tab>
                        </tabs>
                    </tab>
                    <tab name="Details" v-bind:key="'Details'">
                        <details-tab v-if="project" :project="project"></details-tab>
                    </tab>
                    <tab name="Quote & Products" v-bind:key="'Quote & Products'">
                        <quote-products v-if="project" :project="project"></quote-products>
                    </tab>
                    <tab name="Project Journey" v-bind:key="'Project Journey'">
                        <tabs :classes="['card-header']">
                            <tab name="Site Survey" :count="site_surveys.length" selected="selected">
                                <site-survey-tab :project_id="project.id" :user_id="user_id" :site_surveys="site_surveys"></site-survey-tab>
                            </tab>
                            <tab name="Design & Concept" :count="concept_artwork.length">
                                <design-concept-tab :project_id="project.id" :user_id="user_id" :existing_concept_artwork="concept_artwork"></design-concept-tab>
                            </tab>
                            <tab :count="general_artwork.length">
                                <artwork-tab :project_id="project.id" :user_id="user_id" :existing_artwork="general_artwork"></artwork-tab>
                            </tab>
                            <tab name="Internal Approval" :count="artwork_needing_internal_approval.length">
                                <internal-approval-tab :project_id="project.id" :user_id="user_id" :artwork="artwork_formatted"></internal-approval-tab>
                            </tab>
                            <tab name="Client Approval" :count="artwork_needing_client_approval.length">
                                <client-approval-tab :project_id="project.id" :artwork="artwork_formatted"></client-approval-tab>
                            </tab>
                            <tab name="Print" :count="ready_to_print_artwork.length">
                                <print-tab :project_id="project.id" :artwork="ready_to_print_artwork"></print-tab>
                            </tab>
                            <tab name="Event Photos" :count="event_photos.length">
                                <event-photos-tab :project_id="project.id" :artwork="event_photos"></event-photos-tab>
                            </tab>
                        </tabs>
                    </tab>
                    <tab name="Documents" v-bind:key="'Documents'">
                        <documents-tab v-if="project" :base_folder_name="'project'" :item_id="project.id"></documents-tab>
                    </tab>
                </tabs>
            </div>
        </div>
        <project-journey-modals :user_id="user_id" :project_id="project_id"></project-journey-modals>
    </div>
</template>

<script>
    import ArtworkHelper from '../../../../../components/mixins/artwork-helper';
    import ProjectHelper from '../../../../../components/mixins/project-helper';

    import modal from '../../../../../components/modal'
    import ProjectSummary from './quick-info/project-summary';
    import ProjectStatus from './quick-info/project-status';
    import Team from './quick-info/team/team';
    import DetailsTab from './tabs/details/details-tab';
    import Labour from './task-additionals/labour'
    import Accommodation from './task-additionals/accommodation'
    import Transport from './task-additionals/transport'
    import AddNewTaskListCategoryModal from '../../../../../components/modals/task/list/add-new-task-list-category-modal'
    import SiteSurveyTab from './tabs/project-journey/tabs/site-survey-tab';
    import DesignConceptTab from './tabs/project-journey/tabs/design-concept-tab';
    import ArtworkTab from './tabs/project-journey/tabs/artwork-tab';
    import InternalApprovalTab from './tabs/project-journey/tabs/internal-approval/internal-approval-tab';
    import ClientApprovalTab from './tabs/project-journey/tabs/client-approval/client-approval-tab';
    import PrintTab from './tabs/project-journey/tabs/print-tab';
    import DocumentsTab from '../../../../../components/file-manager';
    import QuoteProducts from '../quote-products/quote-products';
    import ProjectJourneyModals from './tabs/project-journey/modals'
    import EventPhotosTab from "./tabs/project-journey/tabs/event-photos-tab";

    export default {
        name: "staff-project",
        components: {
            modal,
            AddNewTaskListCategoryModal,
            EventPhotosTab,
            ProjectSummary,
            ProjectStatus,
            Team,
            SiteSurveyTab,
            DetailsTab,
            Labour,
            Accommodation,
            Transport,
            DesignConceptTab,
            ArtworkTab,
            InternalApprovalTab,
            ClientApprovalTab,
            PrintTab,
            DocumentsTab,
            QuoteProducts,
            ProjectJourneyModals
        },
        mixins: [ArtworkHelper, ProjectHelper],
        props: ['project_id', 'user_id', 'what3words_api_key'],
        data() {
            return {
                addNewTaskListModalCategoryActive: false,
                successModalActive: false,
                successBodyContent: ''
            }
        },
        created() {
            this.loadProject(this.project_id);
            this.loadProjectDepartmentTaskCategories(this.project_id);
            this.loadProjectArtwork(this.project_id);
        },
        mounted() {
            this.$eventHub.$on('artwork-updated', this.loadProjectArtwork);
        },
        methods: {
            taskListCategoryAddedHandler(e) {
                this.addNewTaskListModalCategoryActive = false;
                this.showSuccessModal(e.message);
                this.loadProjectDepartmentTaskCategories(this.project_id);
            },
            showSuccessModal(message) {
                this.successBodyContent = message;
                this.successModalActive = true;
            },
        }
    }
</script>
