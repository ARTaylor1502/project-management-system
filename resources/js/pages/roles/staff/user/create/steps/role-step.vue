<template>
    <div id="role_name_step" class="list-group-item">
        <h2>Role</h2>
        <div class="row">
            <div class="col-md-6">
                <label class="col-form-label" for="role_id">Role</label>
                <dropdown
                        :label="role_label"
                        :options="roles"
                        :id="'role_id'"
                        value-key="id"
                        label-key="name"
                        @input-selected="roleHandler">
                </dropdown>
                <ul v-if="errors['role_id']" class="error-list">
                    <li v-for="error in errors['role_id']">{{error}}</li>
                </ul>
            </div>
            <div v-if="role !== null && role.name === 'Staff'" class="col-md-6">
                <label class="col-form-label" for="department_id">Department</label>
                <dropdown
                        :label="department_label"
                        :options="departments"
                        :id="'role_id'"
                        value-key="id"
                        label-key="name"
                        @input-selected="departmentHandler">
                </dropdown>
                <ul v-if="errors['department_id']" class="error-list">
                    <li v-for="error in errors['department_id']">{{error}}</li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    import dropdown from '../../../../../../components/drop-down'
    import UserHelper from '../../../../../../components/mixins/user-helper'
    import DepartmentHelper from '../../../../../../components/mixins/department-helper'

    export default {
        name: "role-step",
        components: {
            dropdown
        },
        mixins: [UserHelper, DepartmentHelper],
        props: {
            errors: Object
        },
        data() {
            return {
                role: null,
                department: null,
                role_label: 'Select a Role...',
                department_label: 'Select a Department'
            }
        },
        mounted() {
            this.loadRoles();
            this.loadDepartments();
        },
        methods: {
            infoChanged() {
                if(this.role !== null) {
                    this.$emit('role-step-complete', {
                        role: this.role,
                        department: this.department
                    });
                } else {
                    this.$emit('role-step-incomplete');
                }
            },
            roleHandler(e) {
                this.role = e;
                this.infoChanged();
            },
            departmentHandler(e) {
                this.department = e;
                this.infoChanged();
            }
        }
    }
</script>
