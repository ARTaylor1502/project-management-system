<template>
    <modal @close-modal="closeModal">
        <template slot="header">
           Assign File to Category
        </template>
        <template slot="body">
            <form @submit.prevent="assignFileToCategory">
                <div class="form-group">
                    <select class="form-control" v-model="category">
                        <option v-for="file_category in file_categories" :value="file_category.name">{{file_category.name}}</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Assign</button>
            </form>
        </template>
    </modal>
</template>

<script>
    import modal from '../../modal'

    export default {
        name: "assign-file-category-modal",
        components: {
            modal
        },
        props : ['base_folder_name', 'item_id', 'file', 'file_categories','selectedCategory'],
        data() {
            return {
                errors: {},
                category: ''
            }
        },
        created() {
            this.category = this.selectedCategory;
        },
        methods: {
            assignFileToCategory() {
                let self = this;

                if(self.category === 'Uncategorised') {
                    self.category = '';
                }

                axios.post('/api/file/' + self.base_folder_name + '/' + self.item_id + '/files/assign-file', {
                    folder: self.category,
                    existing_file_path: self.file.path
                })
                .then(response => {
                    if(response.data.status === 'success') {
                        self.closeModal();
                        self.$emit('file-assigned', response.data.message);
                    } else if(response.data.status === 'error') {
                        self.errors = response.data.errors;
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            },
            closeModal() {
                this.$emit('assign-file-category-modal-closed');
            }
        }
    }
</script>
