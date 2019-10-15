<template>
    <div class="col-md-6 col-lg-4">
        <h2>Status & Progress</h2>
        <div id="project_statuses"  class="card project-details">
            <div class="card-body">
                <statuses :project="project"></statuses>
            </div>
            <div class="card-footer">
                <task-completion-chart :project="project"></task-completion-chart>
            </div>
        </div>
    </div>
</template>

<script>
    import Statuses from '../statuses';
    import TaskCompletionChart from '../../../../staff/project/single/task-completion-chart';

    export default {
        name: "project-status",
        props: ['project'],
        components: {
            Statuses,
            TaskCompletionChart
        }
    }
</script>
