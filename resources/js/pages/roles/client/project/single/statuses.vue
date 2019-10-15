<template>
    <div id="project_statuses_select">
        <label class="col-form-label" for="status_id">Status</label>
        <div>
            <span class="status-select">
                <select id="status_id" name="status_id" :class="status_class" v-model="selectedStatus" disabled>
                    <option v-for="status in statuses" :value="status.id">{{status.name}}</option>
                </select>
            </span>
        </div>
    </div>
</template>

<script>

    export default {
        name: "statuses",
        props: ['project'],
        data() {
            return {
                selectedStatus: this.project.status_id,
                statuses: []
            }
        },
        mounted() {
            this.loadProjectStatuses();
        },
        computed: {
            status_class() {
                let self = this, statusClass = '';

                if(self.statuses.length > 0) {
                    let status = self.statuses.filter(function (status) {
                        return status.id === self.selectedStatus;
                    });

                    statusClass = status[0].name.toLowerCase().replace(' ', '-');
                }

                return statusClass;
            }
        },
        methods: {
            loadProjectStatuses() {
                axios.get('/api/project/statuses')
                    .then(response => {
                        response.data.forEach((status) => {
                            this.statuses.push(status);
                        });
                    }).catch(function (error) {
                    console.log(error);
                });
            }
        }
    }
</script>
