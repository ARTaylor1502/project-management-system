<template>
    <div>
        <div class="nav nav-tabs">
            <span class="nav-item nav-link" :class="{ active: stage === 1}">Details</span>
            <span class="nav-item nav-link" :class="{ active: stage === 2}">Quotes & Products</span>
        </div>
        <div class="tab-content">
            <div v-show="stage === 1" class="tab-pane show active" id="details_tab" role="tabpanel" aria-labelledby="nav-details-tab">
                <Details :project_data="project_data" :revisit="revisit" @stage-complete="updateStageNumber(2)"></Details>
            </div>
            <div v-show="stage === 2" class="tab-pane show active" id="quotes_products_tab" role="tabpanel" aria-labelledby="nav-quotes-products-tab">
                <quotes-products :project="project_data" @quote-products-changed="updateProducts">
                    <template slot="caveat">
                        <h4 class="caveat">This can be added later</h4>
                    </template>
                </quotes-products>
                <button class="btn btn-secondary btn-lg" @click="goBackHandler">Back</button>
                <button class="btn btn-primary btn-lg float-right" @click="addProjectHandler">Add Project</button>
            </div>
        </div>
    </div>
</template>

<script>
    import Details from './details/details';
    import QuotesProducts from '../quote-products/quote-products';
    import ProjectHelper from '../../../../../components/mixins/project-helper'

    export default {
        name: "create-project",
        components: {
            Details,
            QuotesProducts
        },
        mixins: [ProjectHelper],
        data() {
            return {
                project_data: {
                    name: '',
                    type: {},
                    event: {},
                    client: {},
                    client_contact: {},
                    venue: {},
                    status: {},
                    user: {},
                    project_owner: {},
                    brief: '',
                    formData: null,
                    files: [],
                    products: []
                },
                form: null,
                stage: 1,
                revisit: false
            }
        },
        created() {
          this.$eventHub.$on('new-project-added', this.newProjectAddedHandler);
        },
        methods: {
            updateStageNumber(stage_number) {
                this.stage = stage_number;
            },
            goBackHandler() {
                this.updateStageNumber(1);
                this.revisit = true;
            },
            updateProducts(e) {
                this.project_data.products = e.products;
            },
            addProjectHandler() {
                this.populateForm();
                this.addProject(this.formData);
            },
            populateForm() {
                this.formData = new FormData();

                this.formData.append('name', this.project_data.name);
                this.formData.append('project_type_id', this.project_data.type.id);
                this.formData.append('event_id', this.project_data.event.id);
                this.formData.append('client_id', this.project_data.client.id);
                this.formData.append('client_contact_id', this.project_data.client_contact.id);
                this.formData.append('venue_id', this.project_data.venue.id);
                this.formData.append('status_id', this.project_data.status.id);
                this.formData.append('project_owner_id', this.project_data.project_owner.id);
                this.formData.append('brief', this.project_data.brief);

                for(let i = 0; i < this.project_data.products.length; i++){
                    let product = this.project_data.products[i];
                    this.formData.append('products[' + i + '][id]', product.id);
                    this.formData.append('products[' + i + '][quantity]', product.quantity);
                }

                for(let i = 0; i < this.project_data.files.length; i++ ){
                    let file = this.project_data.files[i];
                    this.formData.append('files[' + i + ']', file);
                }
            },
            newProjectAddedHandler(project_id) {
                window.location.href = '/projects/project/' + project_id;
            }
        }
    }
</script>
