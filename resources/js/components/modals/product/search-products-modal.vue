<template>
    <modal @close-modal="closeModal">
        <template slot="header">

        </template>
        <template slot="body">
            <div class="form-group">
                <label class="col-form-label" for="search_products">Search for Products to Add</label>
                <div class="autocomplete">
                    <input class="form-control" id="search_products" name="product_name" type="text" v-model="queryString" @keyup="searchProducts">
                    <div v-if="query_results_window_opened" class="options">
                        <div class="options-container">
                            <div v-for="product in search_products" class="option" @click="addProduct(product)">{{product.name}} - £{{product.cost}}</div>
                        </div>
                        <div class="trigger" @click="$emit('show-add-product-modal')">Add New +</div>
                    </div>
                </div>
            </div>
        </template>
    </modal>
</template>

<script>
    import modal from '../../modal';

    export default {
        name: "search-products-modal",
        components: {
            modal
        },
        data() {
          return {
              queryString: '',
              query_results_window_opened: false,
              search_products: [],
              product: {},
          }
        },
        methods: {
            searchProducts() {
                if(this.queryString.length > 0) {
                    axios.get(this.$route('api.product.search'), {params: {queryString: this.queryString}})
                    .then(response => {
                        this.search_products = [];

                        response.data.forEach((product) => {
                            this.search_products.push(product);
                        });
                    }).catch(function (error) {
                        console.log(error);
                    });
                }

                this.query_results_window_opened = true;
            },
            addProduct(product) {
                this.$emit('product-added', product);
            },
            closeModal() {
                this.queryString = '';
                this.search_products = [];
                this.$emit('search-products-modal-closed');
            }
        }
    }
</script>
