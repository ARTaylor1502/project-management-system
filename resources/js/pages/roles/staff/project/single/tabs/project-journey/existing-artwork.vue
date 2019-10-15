<template>
    <div>
        <div class="list-container">
            <div class="list-header">
                <h3>Awaiting Internal Approval <span class="badge">{{awaiting_internal_approval_artwork.length}}</span></h3>
            </div>
            <div v-if="awaiting_internal_approval_artwork.length > 0" class="list-group list-group-striped mb-0">
                <div v-for="a in awaiting_internal_approval_artwork" class="list-group-item">
                    <div class="row">
                        <div class="offset-sm-2 col-sm-4 mr-5">
                            <artwork-preview :artwork_src="a.src"></artwork-preview>
                        </div>
                        <div class="col-sm-4">
                            <h3>{{a.name}}</h3>
                            <h4 v-if="a.what3words_code !== null">What3Words Code: {{a.what3words_code}}</h4>
                            <h4 v-if="a.material !== null">Material: {{a.material}}</h4>
                            <h4 v-if="a.print_code !== null">Print code: {{a.print_code}}</h4>
                            <h4>Size: W {{a.height}}mm x H {{a.width}}mm x D {{a.depth}}mm</h4>
                            <h4>Description: {{a.description}}</h4>
                            <button v-if="a.latest_internal_amend_request && !a.latest_internal_amend_made" class="btn btn-primary" @click="$eventHub.$emit('view-amend-request', a.latest_internal_amend_request)">View Requested Amends <i class="fas fa-eye"></i></button>
                            <button v-if="a.latest_internal_amend_request && !a.latest_internal_amend_made" class="btn btn-success ml-3" @click="$eventHub.$emit('add-amended-artwork', a, a.latest_internal_amend_request)">Amend Artwork <i class="fas fa-edit"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="list-group list-group-striped mb-0">
                <div class="list-group-item">No {{artwork_type}} awaiting internal approval</div>
            </div>
        </div>
        <div class="list-container">
            <div class="list-header">
                <h3>Awaiting Client Approval <span class="badge">{{awaiting_client_approval_artwork.length}}</span></h3>
            </div>
            <div v-if="awaiting_client_approval_artwork.length > 0" class="list-group list-group-striped mb-0">
                <div v-for="a in awaiting_client_approval_artwork" class="list-group-item">
                    <div class="row">
                        <div class="offset-sm-2 col-sm-4 mr-5">
                            <artwork-preview :artwork_src="a.src"></artwork-preview>
                        </div>
                        <div class="col-sm-4">
                            <h3>{{a.name}}</h3>
                            <h4 v-if="a.what3words_code !== null">What3Words Code: {{a.what3words_code}}</h4>
                            <h4 v-if="a.material !== null">Material: {{a.material}}</h4>
                            <h4 v-if="a.print_code !== null">Print code: {{a.print_code}}</h4>
                            <h4>Size: W {{a.height}}mm x H {{a.width}}mm x D {{a.depth}}mm</h4>
                            <h4>Description: {{a.description}}</h4>
                            <button v-if="a.latest_client_amend_request && !a.latest_client_amend_made" class="btn btn-primary" @click="$eventHub.$emit('view-amend-request', a.latest_client_amend_request)">View Requested Amends <i class="fas fa-eye"></i></button>
                            <button v-if="a.latest_client_amend_request && !a.latest_client_amend_made" class="btn btn-success ml-3" @click="$eventHub.$emit('add-amended-artwork', a, a.latest_client_amend_request)">Amend Artwork <i class="fas fa-edit"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="list-group list-group-striped mb-0">
                <div class="list-group-item">No {{artwork_type}} awaiting client approval</div>
            </div>
        </div>
        <div class="list-container">
            <div class="list-header">
                <h3>Approved <span class="badge">{{approved_artwork.length}}</span></h3>
            </div>
            <div v-if="approved_artwork.length > 0" class="list-group list-group-striped mb-0">
                <div v-for="a in approved_artwork" class="list-group-item">
                    <div class="row">
                        <div class="offset-sm-2 col-sm-4 mr-5">
                            <artwork-preview :artwork_src="a.src"></artwork-preview>
                        </div>
                        <div class="col-sm-4">
                            <h3>{{a.name}}</h3>
                            <h4 v-if="a.what3words_code !== null">What3Words Code: {{a.what3words_code}}</h4>
                            <h4 v-if="a.material !== null">Material: {{a.material}}</h4>
                            <h4 v-if="a.print_code !== null">Print code: {{a.print_code}}</h4>
                            <h4>Size: W {{a.height}}mm x H {{a.width}}mm x D {{a.depth}}mm</h4>
                            <h4>Description: {{a.description}}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="list-group list-group-striped mb-0">
                <div class="list-group-item">No {{artwork_type}} approved</div>
            </div>
        </div>
    </div>
</template>

<script>
    import ArtworkPreview from './artwork-preview'

    export default {
        name: "existing-artwork",
        components: {
            ArtworkPreview
        },
        props: ['artwork', 'artwork_type', 'user_id'],
        data() {
            return {
                selected_artwork_index: null,
                selected_artwork: false,
                selected_amend_request: false
            }
        },
        computed: {
            awaiting_internal_approval_artwork() {
                return this.artwork.filter(function (a) {
                    return !a.internally_approved && !a.client_approved;
                });
            },
            awaiting_client_approval_artwork() {
                return this.artwork.filter(function (a) {
                    return a.internally_approved && !a.client_approved;
                });
            },
            approved_artwork() {
                return this.artwork.filter(function (a) {
                    return a.internally_approved && a.client_approved;
                });
            },
        }
    }
</script>
