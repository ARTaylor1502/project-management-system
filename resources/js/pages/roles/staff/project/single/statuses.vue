<template>
    <div>
        <label class="col-form-label pt-0" for="status_id">Status</label>
        <div>
            <span class="status-select">
                <select id="status_id" name="status_id" :class="status_class" v-model="selectedStatus" v-on:change="updateStatus()">
                    <option v-for="status in statuses" :value="status.id">{{status.name}}</option>
                </select>
            </span>
        </div>
    </div>
</template>

<script>
    var eventHub = new Vue();

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
                axios.get(this.$route('api.project.statuses'))
                .then(response => {
                    response.data.forEach((status) => {
                        this.statuses.push(status);
                    });
                }).catch(function (error) {
                    console.log(error);
                });
            },
            updateStatus() {
                axios.put(this.$route('api.project.update', this.project.id),{status_id : this.selectedStatus})
                .then(response => {
                    if(response.data.status === 'success') {
                        this.$eventHub.$emit('project-updated');
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            }
        }
    }
</script>
