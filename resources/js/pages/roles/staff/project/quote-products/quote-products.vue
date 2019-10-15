<template>
    <div>
        <div class="card">
            <div class="card-body">
                <h2><span v-if="project.type">{{project.type.name}} </span>Quote Builder</h2>
                <slot name="caveat"></slot>
                <ul v-show="quote_products.length > 0" class="list">
                    <li class="list-item" v-for="product in quote_products">
                        <span class="row">
                            <span class="col-md-6">
                                <span class="item-toggle"><i class="remove-item fas fa-minus-circle" @click="removeProductHandler(product)"></i></span>
                                <span class="item-title text-truncate">{{product.name}} </span>
                                <strong class="quantity">x{{product.quantity}}</strong>
                            </span>
                             <span class="right-container col-md-6">
                                <span>£{{product.cost}}</span>
                            </span>
                        </span>
                    </li>
                </ul>
                <button class="btn primary-custom" @click="searchProductsModalActive = true">Add Products to Quote <i class="fal fa-plus"></i></button>
            </div>
            <div class="card-footer text-right">
                <span id="quote_total_container">Total: £<span id="quote_total">{{quote_total}}</span></span>
            </div>
            <search-products-modal v-show="searchProductsModalActive === true"
                                   @search-products-modal-closed="searchProductsModalActive = false"
                                   @show-add-product-modal="addProductModalActive = true"
                                   @product-added="addProductHandler">
            </search-products-modal>
            <add-product-modal v-show="addProductModalActive === true"
                               @add-product-modal-closed="addProductModalActive = false"
                               @product-added="showSuccessModal">
            </add-product-modal>
            <modal v-show="successModalActive === true"
                   @close-modal="closeSuccessModal">
                <template slot="header">Success</template>
                <template slot="body">{{successBodyContent}}</template>
            </modal>
        </div>
    </div>
</template>

<script>
    import modal from '../../../../../components/modal';
    import addProductModal from '../../../../../components/modals/product/add-product-modal';
    import searchProductsModal from '../../../../../components/modals/product/search-products-modal';

    export default {
        name: "quote-products",
        components: {
            modal,
            addProductModal,
            searchProductsModal
        },
        data() {
            return {
                queryString: '',
                query_results_window_opened: false,
                searchProductsModalActive: false,
                addProductModalActive: false,
                successModalActive: false,
                product_categories: [],
                cost_types: [],
                quote_products: [],
                successBodyContent: ''
            }
        },
        props: ['project'],
        mounted() {
            this.quote_products = this.project.products;
        },
        computed: {
            quote_total() {
                let total = 0;

                this.quote_products.forEach( (product ) => {
                    if(product.quantity > 1) {
                        total += (parseFloat(product.cost) * product.quantity);
                    } else {
                        total += parseFloat(product.cost);
                    }
                });

                return total.toFixed(2);
            }
        },
        methods: {
            addProductHandler(product) {
                this.addProductToQuote(product);
                this.$emit('quote-products-changed', {
                    products: this.quote_products
                });
            },
            removeProductHandler(product){
                this.removeProductFromQuote(product);
                this.$emit('quote-products-changed', {
                    products: this.quote_products
                });
            },
            addProductToQuote(product) {
                if(this.quote_products.indexOf(product) === -1) {
                    product.quantity = 1;
                    this.quote_products.push(product);
                } else {
                    product.quantity += 1;
                }
            },
            removeProductFromQuote(product) {
                this.quote_products.splice(this.quote_products.indexOf(product), 1);
            },
            showSuccessModal(modal_content) {
                this.successBodyContent = modal_content;
                this.successModalActive = true;
            },
            closeSuccessModal() {
                this.successModalActive = false;
            }
        }
    }
</script>
