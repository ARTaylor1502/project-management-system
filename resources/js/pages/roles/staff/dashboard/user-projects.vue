<template>
    <div>
        <slot name="heading"></slot>
        <div class="row">
            <div v-for="project in projects" class="col-md-6 col-md-4 col-lg-3">
                <project-summary :project="project"></project-summary>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "user-projects",
        props: ['staff_id'],
        data() {
            return {
                projects: []
            }
        },
        created() {
            this.loadUserProjects();
        },
        methods: {
            loadUserProjects() {
                let self = this;

                axios.get('/api/project/user/'+self.staff_id+'?limit=5')
                .then(response => {
                    self.resetProjects();

                    response.data.forEach(function(project) {
                        self.projects.push(project);
                    });
                }).catch(function (error) {
                    console.log(error);
                });
            },
            resetProjects() {
                this.projects = [];
            }
        }
    }
</script>
