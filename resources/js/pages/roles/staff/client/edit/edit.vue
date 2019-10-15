<template>
    <tabs>
        <tab name="Details" selected="true">
            <client-details v-if="client" :existing_client="client" :what3words_api_key="what3words_api_key"></client-details>
        </tab>
        <tab name="Documents">
            <client-documents v-if="client" :base_folder_name="'clients'" :item_id="client.id"></client-documents>
        </tab>
        <tab name="Users">
            <client-users :users="project_owners"></client-users>
        </tab>
        <tab name="Projects" :count="projects_count">
            <client-projects v-if="client.projects" :projects="client.projects"></client-projects>
        </tab>
        <tab name="Passwords">
            <client-passwords v-if="client.passwords" :client_id="client.id" :passwords="client.passwords"></client-passwords>
        </tab>
    </tabs>
</template>

<script>
    import ClientDetails from './tabs/details';
    import ClientUsers from "./tabs/users";
    import ClientProjects from "./tabs/projects";
    import ClientDocuments from "../../../../../components/file-manager";
    import ClientPasswords from "./tabs/passwords";
    import ClientHelper from "../../../../../components/mixins/client-helper"

    export default {
        name: "edit",
        components: {
            ClientDocuments,
            ClientProjects,
            ClientUsers,
            ClientDetails,
            ClientPasswords
        },
        mixins: [ClientHelper],
        props: ['client_id', 'what3words_api_key'],
        data() {
            return {
                client: false
            }
        },
        created() {
            this.loadClient(this.client_id);
        },
        mounted() {
            this.$eventHub.$on('client-updated', this.loadClient);
        },
        computed: {
          project_owners() {
              let users = [];

              if(this.client) {
                  this.client.projects.forEach(function (project) {
                      users.push(project.project_owner)
                  });
              }

              return users;
          },
          projects_count() {
              let count = 0;

              if(this.client) {
                  count = this.client.projects.length;
              }

              return count;
          }
        }
    }
</script>
