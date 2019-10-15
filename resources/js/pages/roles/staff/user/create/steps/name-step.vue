<template>
    <div id="add_client_name_step" class="list-group-item">
        <h2>Name</h2>
        <div class="row">
            <div class="col-md-6">
                <label class="col-form-label" for="title_id">Title</label>
                <dropdown
                        :label="title_label"
                        :options="titles"
                        :id="'title_id'"
                        value-key="id"
                        label-key="name"
                        @input-selected="titleHandler">
                </dropdown>
                <ul v-if="errors['title_id']" class="error-list">
                    <li v-for="error in errors['title_id']">{{error}}</li>
                </ul>
            </div>
            <div class="col-md-6">
                <label class="col-form-label" for="first_name">First Name</label>
                <input v-model="first_name" class="form-control" id="first_name" name="first_name" type="text" @keyup="infoChanged">
                <ul v-if="errors['first_name']" class="error-list">
                    <li v-for="error in errors['first_name']">{{error}}</li>
                </ul>
            </div>
            <div class="col-md-6">
                <label class="col-form-label" for="last_name">Last Name</label>
                <input v-model="last_name" class="form-control" id="last_name" name="last_name" type="text" @keyup="infoChanged">
                <ul v-if="errors['last_name']" class="error-list">
                    <li v-for="error in errors['last_name']">{{error}}</li>
                </ul>
            </div>
            <div class="col-md-6">
                <label class="col-form-label" for="password">Password</label>
                <input v-model="password" class="form-control" id="password" name="password" type="password" @keyup="infoChanged">
                <ul v-if="errors['password']" class="error-list">
                    <li v-for="error in errors['password']">{{error}}</li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    import dropdown from '../../../../../../components/drop-down'

    export default {
        name: "name-step",
        components: {
            dropdown
        },
        props: {
            errors: Object
        },
        data() {
            return {
                first_name: '',
                last_name: '',
                password: '',
                title: null,
                title_label: 'Select a Title...',
                titles: []
            }
        },
        mounted() {
            this.loadUserTitles();
        },
        methods: {
            infoChanged() {
                if(this.first_name.length > 3 && this.last_name.length > 3 && this.title !== null && this.password.length > 3) {
                    this.$emit('name-step-complete', {
                        first_name: this.first_name,
                        last_name: this.last_name,
                        title: this.title,
                        password: this.password
                    });
                } else {
                    this.$emit('name-step-incomplete');
                }
            },
            loadUserTitles() {
                axios.get(this.$route('api.user.titles'))
                .then(response => {
                    response.data.forEach((title) => {
                        this.titles.push(title);
                    });
                }).catch(function (error) {
                    console.log(error);
                });
            },
            titleHandler(e) {
                this.title = e;
                this.infoChanged();
            }
        }
    }
</script>
