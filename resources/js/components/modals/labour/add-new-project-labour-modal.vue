<template>
    <modal @close-modal="closeModal">
        <template slot="header">
            Add New Project Labour
        </template>
        <template slot="body">
            <form @submit.prevent="addLabour">
                <div v-if="staff_member_selected === true && selected_staff_member !== null">
                    <div class="form-group">
                        <h4>Selected Staff Member</h4>
                        <p><i class="fal fa-user mr-3"></i> {{selected_staff_member.first_name}} {{selected_staff_member.last_name}}</p>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="add_labour_start_date">Start Date</label>
                        <input class="form-control" type="date" id="add_labour_start_date" name="add_labour_start_date" v-model="form_data['start_date']"/>
                        <ul v-if="errors['start_date']" class="error-list">
                            <li v-for="error in errors['start_date']">{{error}}</li>
                        </ul>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="add_labour_end_date">End Date</label>
                        <input class="form-control" type="date" id="add_labour_end_date" name="add_labour_end_date" v-model="form_data['end_date']"/>
                        <ul v-if="errors['end_date']" class="error-list">
                            <li v-for="error in errors['end_date']">{{error}}</li>
                        </ul>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="add_labour_responsibilities">Responsibilities</label>
                        <textarea class="form-control" id="add_labour_responsibilities" name="add_labour_responsibilities" v-model="form_data['responsibilities']"></textarea>
                        <ul v-if="errors['responsibilities']" class="error-list">
                            <li v-for="error in errors['responsibilities']">{{error}}</li>
                        </ul>
                    </div>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
                <div v-else class="form-group autocomplete">
                    <label class="col-form-label" for="user_search">User</label>
                    <div class="autocomplete">
                        <input class="form-control" id="user_search" name="user_search" type="text" placeholder="Search for existing user" v-model="staff_search_query" @keyup="searchStaffMembers">
                        <div v-if="query_results_window_opened" class="options">
                            <div class="options-container">
                                <div v-for="staff_member in staff" class="option" @click="selectStaffMemberHandler(staff_member)">{{staff_member.first_name}} {{staff_member.last_name}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </template>
    </modal>
</template>

<script>
    import modal from '../../modal'

    export default {
        name: "add-new-project-labour-modal",
        props: ['project_id'],
        components: {
            modal
        },
        data() {
            return {
                errors: {},
                form_data: {
                    project_id: this.project_id,
                    user_id: null,
                    start_date: null,
                    end_date: null,
                    responsibilities: null
                },
                staff: [],
                staff_search_query: '',
                query_results_window_opened: '',
                selected_staff_member: null,
                staff_member_selected: false
            }
        },
        methods: {
            addLabour() {
                axios.post(this.$route('api.project.store.labour'), this.form_data)
                .then(response => {
                    if(response.data.status === 'success') {
                        this.$emit('project-labour-added', response.data);
                    } else if(response.data.status === 'error') {
                        this.errors = response.data.errors;
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            },
            searchStaffMembers() {
                if(this.staff_search_query.length > 2) {
                    axios.post(this.$route('api.user.search'), {query_string: this.staff_search_query})
                    .then(response => {
                        this.staff = [];

                        response.data.forEach((staff_member) => {
                            this.staff.push(staff_member);
                        });

                        this.query_results_window_opened = true;

                    }).catch(function (error) {
                        console.log(error);
                    });
                }
            },
            selectStaffMemberHandler(staff_member) {
                this.selected_staff_member = staff_member;
                this.form_data.user_id = staff_member.id;
                this.staff_member_selected = true;
                this.query_results_window_opened = false;
            },
            closeModal() {
                this.$emit('add-new-project-transport-modal-closed');
            }
        }
    }
</script>
