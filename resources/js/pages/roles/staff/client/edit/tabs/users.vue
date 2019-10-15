<template>
    <div>
        <div v-if="users.length > 0" class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Email</th>
                        <th>Landline Tele</th>
                        <th>Mobile Number</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users">
                        <td>
                            <span class="text-truncate">{{user.full_name}}</span>
                        </td>
                        <td>
                            <span v-if="user.department" class="text-truncate">{{user.department.name}}</span>
                            <span v-else class="text-truncate">N/A</span>
                        </td>
                        <td>
                            <span class="text-truncate">{{user.email}}</span>
                        </td>
                        <td>
                            <span class="text-truncate">{{user.landline_tele}}</span>
                        </td>
                        <td>
                            <span class="text-truncate">{{user.mobile_tele}}</span>
                        </td>
                        <td>
                            <a class="btn btn-sm btn-primary action-btn" :href="$route('staff.user.edit', user.id)">View</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-if="!users.length > 0">
            <p>No users currently assigned to any client projects</p>
        </div>
    </div>
</template>

<script>
    export default {
        name: "client-users",
        props: ['users']
    }
</script>
