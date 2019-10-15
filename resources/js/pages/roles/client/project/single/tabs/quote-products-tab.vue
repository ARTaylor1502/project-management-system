<template>
    <div class="card">
        <div class="card-body">
            <ul v-show="quote_products.length > 0" class="list">
                <li class="list-item" v-for="product in quote_products">
                    <span class="row">
                        <span class="col-md-6">
                            <span class="item-title text-truncate">{{product.name}} </span>
                            <strong class="quantity">x{{product.quantity}}</strong>
                        </span>
                         <span class="right-container col-md-6">
                            <span>£{{product.cost}}</span>
                        </span>
                    </span>
                </li>
            </ul>
        </div>
        <div class="card-footer text-right">
            <span id="quote_total_container">Total: £<span id="quote_total">{{quote_total}}</span></span>
        </div>
    </div>
</template>

<script>
    export default {
        name: "client-project-quote-products-tab",
        data() {
            return {
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
    }
</script>
