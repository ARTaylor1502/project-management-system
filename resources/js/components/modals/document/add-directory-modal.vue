<template>
    <modal @close-modal="closeModal">
        <template slot="header">
            Add New Directory
        </template>
        <template slot="body">
            <form @submit.prevent="addDirectory">
                <div class="form-group">
                    <label class="col-form-label" for="directory_name">Directory Name</label>
                    <input id="directory_name" class="form-control" type="text"  v-model="directoryName">
                </div>
                <button type="submit" class="btn btn-primary">Add</button>
            </form>
        </template>
    </modal>
</template>

<script>
    import modal from '../../modal'

    export default {
        name: "add-directory-modal",
        components: {
            modal
        },
        props: ['base_folder_name', 'item_id'],
        data() {
            return {
                errors: {},
                directoryName: '',
            }
        },
        methods: {
            closeModal() {
                this.$emit('add-directory-modal-closed');
            },
            addDirectory() {
                let self = this;

                axios.post(this.$route('api.file.add.directory', self.base_folder_name, self.item_id), {
                    directory_name: self.directoryName
                })
                .then(response => {
                    if(response.data.status === 'success') {
                        self.closeModal();
                        self.$emit('directory-added', response.data.message);
                    } else if(response.data.status === 'error') {
                        self.errors = response.data.errors;
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            }
        }
    }
</script>
