<template>
    <div id="add_client_name_step" class="list-group-item">
        <h2>Name</h2>
        <div class="row">
            <div class="col-md-6">
                <label class="col-form-label" for="client_name">Client Name</label>
                <input v-model="name" class="form-control" id="client_name" name="client_name" type="text" @keyup="infoChanged">
                <ul v-if="errors['name']" class="error-list">
                    <li v-for="error in errors['name']">{{error}}</li>
                </ul>
            </div>
            <div class="col-md-6">
                <label class="col-form-label" for="client_type_id">Client Type</label>
                <dropdown
                        :label="label"
                        :options="client_types"
                        :id="'client_type_id'"
                        value-key="id"
                        label-key="name"
                        @input-selected="handler">
                </dropdown>
                <ul v-if="errors['client_type_id']" class="error-list">
                    <li v-for="error in errors['client_type_id']">{{error}}</li>
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
                name: '',
                type: null,
                label: 'Select a Client Type...',
                client_types: []
            }
        },
        mounted() {
            this.loadClientTypes();
        },
        methods: {
            infoChanged() {
                if(this.name.length > 3 && this.type !== null) {
                    this.$emit('name-step-complete', {
                        name: this.name,
                        client_type: this.type
                    });
                } else {
                    this.$emit('name-step-incomplete');
                }
            },
            loadClientTypes() {
                axios.get(this.$route('api.client.types'))
                .then(response => {
                    response.data.forEach((client_type) => {
                        this.client_types.push(client_type);
                    });
                }).catch(function (error) {
                    console.log(error);
                });
            },
            handler(e) {
                this.type = e;
                this.infoChanged();
            },
        }
    }
</script>
