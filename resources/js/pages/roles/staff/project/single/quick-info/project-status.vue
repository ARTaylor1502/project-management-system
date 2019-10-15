<template>
    <div class="col-md-6 col-lg-4">
        <h2>Status & Progress</h2>
        <div class="card h-100">
            <div class="card-body h-50">
                <statuses :project="project"></statuses>
            </div>
            <div class="card-footer h-50 flex-vertical-align">
                <task-completion-chart :project="project"></task-completion-chart>
            </div>
        </div>
    </div>
</template>

<script>
    import Statuses from '../statuses';
    import TaskCompletionChart from '../task-completion-chart';

    export default {
        name: "project-status",
        props: ['project'],
        components: {
            Statuses,
            TaskCompletionChart
        }
    }
</script>
