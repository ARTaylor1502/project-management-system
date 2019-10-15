<template>
    <div>
        <div v-if="artwork_approved" class="alert alert-success mb-0">
            <i class="fas fa-times cursor-pointer float-right" @click="artwork_approved = false"></i>
            {{category_type}} successfully approved. The survey will now be submitted for client approval
        </div>
        <div class="list-container">
            <div class="list-header">
                <h3>Awaiting Approval <span class="badge">{{artwork_awaiting_approval.length}}</span></h3>
            </div>
            <div v-if="artwork_awaiting_approval.length > 0" class="list-group list-group-striped mb-0">
                <div v-for="a in artwork_awaiting_approval" class="list-group-item">
                    <div class="row">
                        <div class="offset-sm-2 col-sm-4 mr-5">
                            <artwork-preview :artwork_src="a.src"></artwork-preview>
                        </div>
                        <div class="col-sm-4">
                            <h3>{{a.name}} </h3>
                            <h4 v-if="a.what3words_code !== null">What3Words Code: {{a.what3words_code}}</h4>
                            <h4 v-if="a.material !== null">Material: {{a.material}}</h4>
                            <h4 v-if="a.print_code !== null">Print Code: {{a.print_code}}</h4>
                            <h4>Size: W {{a.height}}mm x H {{a.width}}mm x D {{a.depth}}mm</h4>
                            <h4>Description: {{a.description}}</h4>
                            <button v-if="displayApproveArtwork(a)" class="btn btn-success mr-4" @click="$eventHub.$emit('request-artwork-approval', a)">Approve <i class="fas fa-check-square"></i></button>
                            <button v-if="displayViewAmends(a)" class="btn btn-warning mr-4" @click="$eventHub.$emit('view-amends-comparison', { amend_request : a.latest_internal_amend_request, previous_artwork: a.previous_artwork, amended_artwork : a})">View Amends Made <i class="fas fa-eye"></i></button>
                            <button v-if="displayRequestAmends(a)" class="btn btn-danger mr-4" @click="$eventHub.$emit('request-artwork-amends', a)">Request Amends <i class="fas fa-edit"></i></button>
                            <button v-else class="btn btn-primary" @click="$eventHub.$emit('view-amend-request', a.latest_internal_amend_request)">View Requested Amends <i class="fas fa-eye"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="list-group list-group-striped mb-0">
                <div class="list-group-item">No {{category_type}} awaiting approval/amends</div>
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
                            <h3>{{a.name}} </h3>
                            <h4 v-if="a.what3words_code !== null">What3Words Code: {{a.what3words_code}}</h4>
                            <h4 v-if="a.material !== null">Material: {{a.material}}</h4>
                            <h4 v-if="a.print_code !== null">Print Code: {{a.print_code}}</h4>
                            <h4>Size: W {{a.height}}mm x H {{a.width}}mm x D {{a.depth}}mm</h4>
                            <h4>Description: {{a.description}}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="list-group list-group-striped mb-0">
                <div class="list-group-item">No {{category_type}} approved</div>
            </div>
        </div>
    </div>
</template>

<script>
    import ArtworkPreview from "../../artwork-preview";

    export default {
        name: "internal-approval-artwork",
        components: {
            ArtworkPreview
        },
        props: ['artwork', 'category_type'],
        data() {
            return {
                artwork_approved: false
            }
        },
        computed: {
            artwork_awaiting_approval() {
                return this.artwork.filter(function (a) {
                    return a.internally_approved === 0;
                });
            },
            approved_artwork() {
                return this.artwork.filter(function (a) {
                    return a.internally_approved === 1;
                });
            }
        },
        methods: {
            displayApproveArtwork(artwork) {
                return !!(!artwork.latest_internal_amend_request);
            },
            displayRequestAmends(artwork) {
                return !!(!artwork.latest_internal_amend_request && !artwork.latest_internal_amend_made);
            },
            displayViewAmends(artwork) {
                return artwork.latest_internal_amend_made;
            }
        }
    }
</script>
