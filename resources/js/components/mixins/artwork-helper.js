export default {
    data () {
      return {
          artwork: [],
      }
    },
    computed: {
        artwork_formatted() {
            let formatted_artwork = [], self = this;

            this.artwork.forEach(function(a) {
                let latest_amend = self.getLatestAmend(a);
                let previous_artwork = self.getPreviousArtwork(a);
                let latest_internal_amend_request = self.getLatestInternalAmendRequest(a);
                let latest_client_amend_request = self.getLatestClientAmendRequest(a);

                if(latest_amend) {
                    latest_amend.artwork_type = a.artwork_type;
                    latest_amend.previous_artwork = previous_artwork;
                    latest_amend.latest_internal_amend_request = latest_internal_amend_request;
                    latest_amend.latest_client_amend_request = latest_client_amend_request;

                    if(latest_amend.latest_internal_amend_request) {
                        latest_amend.latest_internal_amend_made = latest_amend.latest_internal_amend_request.id === latest_amend.amend_request_id;
                    } else {
                        latest_amend.latest_internal_amend_made = false;
                    }

                     if(latest_amend.latest_client_amend_request) {
                         latest_amend.latest_client_amend_made = latest_amend.latest_client_amend_request.id === latest_amend.amend_request_id;
                     } else {
                         latest_amend.latest_client_amend_made = false;
                     }

                     latest_amend.artwork_id = a.id;

                     formatted_artwork.push(latest_amend);
                } else {
                    a.previous_artwork = previous_artwork;
                    a.latest_internal_amend_request = latest_internal_amend_request;
                    a.latest_client_amend_request = latest_client_amend_request;
                    a.latest_amend_made = false;

                    formatted_artwork.push(a);
                }
            });

            return formatted_artwork;
        },
        artwork_needing_internal_approval() {
            return this.artwork_formatted.filter(function (a) {
                return !a.internally_approved;
            });
        },
        artwork_needing_client_approval() {
            return this.artwork_formatted.filter(function (a) {
                return a.internally_approved && !a.client_approved;
            });
        },
        ready_to_print_artwork() {
            return this.artwork_formatted.filter(function (a) {
                return a.ready_to_print;
            });
        },
        site_surveys() {
            return this.artwork_formatted.filter(function (a) {
                return a.artwork_type.name === 'Site Survey';
            });
        },
        concept_artwork() {
            return this.artwork_formatted.filter(function (a) {
                return a.artwork_type.name === 'Design & Concept';
            });
        },
        general_artwork() {
            return this.artwork_formatted.filter(function (a) {
                return a.artwork_type.name === 'Artwork';
            });
        },
        event_photos() {
            return this.artwork_formatted.filter(function (a) {
                return a.artwork_type.name === 'Event Photo';
            });
        },
    },
    methods:{
        loadProjectArtwork(project_id) {
            let self = this;

            this.resetArtwork();

            axios.get(this.$route('api.project.all.artwork', project_id))
            .then(response => {
                response.data.forEach((artwork) => {
                    self.artwork.push(artwork);
                });
            }).catch(function (error) {
                console.log(error);
            });
        },
        getLatestAmend(artwork) {
            if(artwork.amends.length > 0) {
                if (artwork.amends.length > 1) {
                    artwork.amends.sort((a, b) => b.id - a.id);
                }

                return artwork.amends[0];
            }

            return false;
        },
        getPreviousArtwork(artwork) {
            if(artwork.amends.length > 0) {
                if (artwork.amends.length > 1) {
                    artwork.amends = artwork.amends.sort((a, b) => b.id - a.id);

                    return artwork.amends[1];
                } else {
                    return artwork;
                }
            }

            return false;
        },
        getLatestInternalAmendRequest(artwork) {
            if(artwork.internal_amend_requests.length > 0) {
                if (artwork.internal_amend_requests.length > 1) {
                    artwork.internal_amend_requests = artwork.internal_amend_requests.sort((a, b) => b.id - a.id);
                }

                return artwork.internal_amend_requests[0];
            }

            return false;
        },
        getLatestClientAmendRequest(artwork) {
            if(artwork.client_amend_requests.length > 0) {
                if(artwork.client_amend_requests.length > 1) {
                    artwork.client_amend_requests = artwork.client_amend_requests.sort((a, b) => b.id - a.id);
                }

                return artwork.client_amend_requests[0];
            }

            return false;
        },
        resetArtwork() {
            this.artwork = [];
        },
        validateArtworkDataPopulated() {
            var artwork_data_valid = true;

            this.artwork.forEach(function(artwork) {
                for(var key in artwork) {
                    if(artwork[key] === "") {
                        artwork_data_valid = false;
                    }
                }
            });

            return artwork_data_valid;
        },
        updateArtworkWhat3WordsCode (e) {
            if(this.artwork.length > 0) {
                if(this.artwork[e.item_id] !== -1) {
                    this.artwork[e.item_id].what3words_code = e.code;
                }
            }
        }
    }
};
