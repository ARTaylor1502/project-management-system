<template>
    <div>
        <div v-if="artwork_url_added" class="alert alert-success mb-0">
            <i class="fas fa-times cursor-pointer float-right" @click="artwork_url_added = false"></i>
            Artwork Location Url successfully saved and marked ready for print
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
                <div v-for="(a,key) in approved_artwork" class="list-group-item">
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
                            <template v-if="a.artwork_url === null">
                                <div class="mt-5">
                                    <label :for="'artwork_location_url_' + key">Artwork Location URL</label>
                                    <input :id="'artwork_location_url_' + key" class="form-control mb-4 btn-sm" placeholder="Insert artwork location URL" v-model="artwork_urls[key]">
                                    <button class="btn btn-primary" @click="saveArtworkLocation(a, artwork_urls[key])">Save</button>
                                </div>
                            </template>
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
        name: "client-approval-artwork",
        props: ['artwork', 'category_type', 'project_id'],
        components: {
            ArtworkPreview
        },
        data() {
            return {
                artwork_urls: [],
                artwork_url_added: false
            }
        },
        computed: {
            artwork_awaiting_approval() {
                return this.artwork.filter(function (a) {
                    return a.internally_approved && !a.client_approved;
                });
            },
            approved_artwork() {
                return this.artwork.filter(function (a) {
                    return a.internally_approved && a.client_approved;
                });
            }
        },
        methods: {
            saveArtworkLocation(artwork, artwork_url) {
                let url = '', self = this, formData;

                if(artwork.artwork_id) {
                    url = 'api.project.update.amend';
                } else{
                    url = 'api.project.update.artwork';
                }

                formData = {
                    ready_to_print: 1,
                    artwork_url: artwork_url
                };

                axios.put(this.$route(url, artwork.id), formData)
                .then(response => {
                    if (response.data.status === 'success') {
                        self.artwork_url_added = true;
                        self.$eventHub.$emit('artwork-updated', self.project_id);
                    } else if (response.data.status === 'error') {
                        console.log(response.data.errors);
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            }
        }
    }
</script>
