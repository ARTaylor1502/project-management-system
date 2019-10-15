<template>
    <modal @close-modal="closeModal">
        <template slot="header">Add new product</template>
        <template slot="body">
            <form @submit.prevent="addProduct()">
                <div class="form-group">
                    <label class="col-form-label" for="name">Product Name</label>
                    <input class="form-control" id="name" name="name" type="text" v-model="formData.name">
                    <span v-if="errors['name']" class="error">{{errors['name']}}</span>
                </div>
                <quantity-selector v-model="formData.quantity_total">
                    <template slot="label">Quantity Total</template>
                </quantity-selector>
                <span v-if="errors['quantity_total']" class="error">{{errors['quantity_total']}}</span>

                <quantity-selector v-model="formData.quantity_available">
                    <template slot="label">Quantity Available</template>
                </quantity-selector>
                <span v-if="errors['quantity_available']" class="error">{{errors['quantity_available']}}</span>

                <div class="form-group">
                    <label class="col-form-label" for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" v-model="formData.description"></textarea>
                    <span v-if="errors['description']" class="error">{{errors['description']}}</span>
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="private_notes">Private Notes - Not seen by client</label>
                    <textarea class="form-control small-tinymce" id="private_notes" name="private_notes" v-model="formData.private_notes"></textarea>
                    <span v-if="errors['private_notes']" class="error">{{errors['private_notes']}}</span>
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="category_id">Product Category</label>
                    <select id="category_id" class="form-control" v-model="formData.category_id">
                        <option v-for="category in product_categories" name="category_id" :value="category.id">{{category.name}}</option>
                    </select>
                    <span v-if="errors['category_id']" class="error">{{errors['category_id']}}</span>
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="cost">Product Cost</label>
                    <div class="row">
                        <div class="input-group col-sm-8">
                            <div class="input-group-prepend">
                                <div class="input-group-text">£</div>
                            </div>
                            <input type="text" class="form-control" id="cost" v-model="formData.cost">
                        </div>
                        <div class="col-sm-4">
                            <select id="cost_type_id" class="form-control" v-model="formData.cost_type_id">
                                <option v-for="type in cost_types" name="cost_type_id" :value="type.id">{{type.name}}</option>
                            </select>
                        </div>
                        <span v-if="errors['cost']" class="error">{{errors['cost']}}</span>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Add</button>
            </form>
        </template>
    </modal>
</template>

<script>
    import modal from '../../modal';
    import quantitySelector from '../../quantity-selector';

    export default {
        name: "add-product-modal",
        components: {
            modal,
            quantitySelector
        },
        data() {
            return {
                errors: [],
                formData: {
                    'name': '',
                    'quantity_total': 0,
                    'quantity_available': 0,
                    'description': '',
                    'private_notes': '',
                    'category_id': null,
                    'cost': 0,
                    'cost_type_id': null
                },
                product_categories: [],
                cost_types: [],
            }
        },
        mounted() {
            this.getProductCategories();
            this.getCostTypes();
        },
        methods: {
            addProduct() {
                let self = this;

                axios.post('/api/product/store', self.formData)
                .then(response => {
                    if(response.data.status === 'success') {
                        self.closeModal();
                        self.$emit('product-added', response.data.message);
                    }
                }).catch(function (error) {
                    if(error.response) {
                        self.errors = error.response.data.errors;
                    }
                });
            },
            getProductCategories() {
                this.product_categories = [];

                axios.get('/api/product/categories')
                    .then(response => {
                        response.data.forEach((category) => {
                            this.product_categories.push(category);
                        });

                        if(this.product_categories.length > 0) {
                            this.formData.category_id = this.product_categories[0].id;
                        }
                    }).catch(function (error) {
                    console.log(error);
                });
            },
            getCostTypes() {
                this.cost_types = [];

                axios.get('/api/product/cost-types')
                .then(response => {
                    response.data.forEach((category) => {
                        this.cost_types.push(category);
                    });

                    if(this.cost_types.length > 0) {
                        this.formData.cost_type_id = this.cost_types[0].id;
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            },
            closeModal() {
                this.$emit('add-product-modal-closed');
            }
        }
    }
</script>
