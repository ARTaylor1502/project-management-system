<template>
    <modal @close-modal="closeModal">
        <template slot="header">
            Add New Event
        </template>
        <template slot="body">
            <form @submit.prevent="addEvent">
                <div class="form-group">
                    <label class="col-form-label" for="name">Name</label>
                    <input class="form-control" id="name" name="name" type="text" v-model="formData['name']">
                    <ul v-if="errors['name']" class="error-list">
                        <li v-for="error in errors['name']">{{error}}</li>
                    </ul>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="start_date">Start Date</label>
                    <input class="form-control" type="date" id="start_date" name="start_date" v-model="formData['start_date']"/>
                    <ul v-if="errors['start_date']" class="error-list">
                        <li v-for="error in errors['start_date']">{{error}}</li>
                    </ul>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="end_date">End Date</label>
                    <input class="form-control" type="date" id="end_date" name="end_date" v-model="formData['end_date']"/>
                    <ul v-if="errors['end_date']" class="error-list">
                        <li v-for="error in errors['end_date']">{{error}}</li>
                    </ul>
                </div>

                <button type="submit" class="btn btn-primary">Add</button>
            </form>
        </template>
    </modal>
</template>

<script>
    import modal from '../../modal'

    export default {
        name: "add-event-modal",
        components: {
            modal
        },
        data() {
            return {
                errors: {},
                formData: {},
            }
        },
        methods: {
            addEvent() {
                let self = this;

                axios.post(this.$route('api.event.store'), self.formData)
                .then(response => {
                    if(response.data.status === 'success') {
                        self.closeModal();
                        self.$emit('event-added', response.data.message);
                    } else if(response.data.status === 'error') {
                        self.errors = response.data.errors;
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            },
            closeModal() {
                this.$emit('event-modal-closed');
            }
        }
    }
</script>
