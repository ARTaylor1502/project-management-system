<template>
    <modal @close-modal="closeModal">
        <template slot="header">Search for What3Words Code</template>
        <template slot="body">
            <div v-if="!what3words_code">
                <div v-if="error.length > 0" class="alert alert-danger mb-0">
                    <i class="fas fa-times cursor-pointer float-right" @click="error = ''"></i>
                    {{error}}
                </div>
                <label class="col-form-label" for="address_postcode">Postcode</label>
                <div class="input-group mb-3">
                    <input class="form-control" type="text" id="address_postcode" placeholder="Enter a postcode" name="address_postcode" v-model="postcode"/>
                    <div class="input-group-append">
                        <span id="postcode_lookup" @click="searchPostcodeHandler" class="input-group-text cta">Lookup</span>
                    </div>
                    <span class="caveat">Enter a postcode and click Lookup to find your starting point for your what3words code</span>
                </div>
            </div>
            <div v-if="what3words_code">
                <label class="col-form-label" for="what3_words_search_code">What3Words Code</label>
                <div class="input-group mb-3">
                    <input class="form-control" type="text" id="what3_words_search_code" placeholder="Enter a postcode" name="what3_words_search_code" v-model="what3words_code" readonly/>
                    <div class="input-group-append">
                        <span @click="codeSelectionHandler" class="input-group-text cta">Use Code</span>
                    </div>
                    <span class="caveat">Click on the 3 x 3m square to generate the desired what3words code. USe the zoom tool if necessary.</span>
                </div>
            </div>
            <div v-show="what3words_code" class="map" :id="'map_'+_uid" ref="map"></div>
        </template>
    </modal>
</template>

<script>
    import modal from '../modal';

    export default {
        name: "what3words-code-search-modal",
        components: {
            modal
        },
        data() {
            return resetData();
        },
        mounted() {
            this.initMap();
            this.addWhat3WordsGridToMap();
        },
        computed: {
            postcode_formatted() {
                return this.postcode.replace(' ', '');
            }
        },
        methods: {
            resetModalData: function (){
                Object.assign(this.$data, resetData());
            },
            closeModal() {
                this.$emit('what3words-code-search-modal-closed');
            },
            getCoordinates() {
                let self = this;

                axios.get(this.$route('api.address.lookup', this.postcode_formatted))
                .then(response => {
                    if(response.data.error) {
                        self.error = response.data.error;
                    } else {
                        this.address_longitude = response.data.lng;
                        this.address_latitude = response.data.lat;
                        this.getWhat3WordsCode(this.address_latitude, this.address_longitude);

                        if(this.latitude !== null && this.longitude !== null) {
                            this.$refs.map.setCenter({lat: parseFloat(this.address_latitude), lng: parseFloat(this.address_longitude) });
                        }
                    }
                }).catch(function (error) {
                    if(error.response) {
                        console.log(error.response.data.errors);
                    }
                });
            },
            searchPostcodeHandler() {
                this.getCoordinates();
            },
            getWhat3WordsCode(latitude, longitude) {
                let self = this;
                what3words.api.convertTo3wa({lat:latitude, lng:longitude}).then(function(response) {
                    self.what3words_code = response.words;
                });
            },
            initMap() {
                let self = this;

                this.$refs.map = new google.maps.Map(document.getElementById("map_"+this._uid), {
                    center: { lat: 51.52086, lng: -0.195499 },
                    zoom: 18
                });

                this.$refs.map.addListener("click", function (event) {
                    self.address_latitude = event.latLng.lat();
                    self.address_longitude = event.latLng.lng();

                    self.getWhat3WordsCode(self.address_latitude, self.address_longitude);
                });
            },
            addWhat3WordsGridToMap() {
                let gridData, self = this;

                // Add the what3words grid to the Google Map data layer once the desired zoom level is meet
                this.$refs.map.addListener('bounds_changed', function() {
                    const zoom = self.$refs.map.getZoom();
                    const loadFeatures = zoom > 17;

                    if (loadFeatures) { // Zoom level is high enough
                        var ne = self.$refs.map.getBounds().getNorthEast();
                        var sw = self.$refs.map.getBounds().getSouthWest();

                        // Call the what3words Grid API to obtain the grid squares within the current visble bounding box
                        what3words.api
                            .gridSectionGeoJson({
                                southwest: {
                                    lat: sw.lat(), lng: sw.lng()
                                },
                                northeast: {
                                    lat: ne.lat(), lng: ne.lng()
                                }
                            }).then(function(data) {
                            if (gridData !== undefined) {
                                for (var i = 0; i < gridData.length; i++) {
                                    self.$refs.map.data.remove(gridData[i]);
                                }
                            }
                            gridData = self.$refs.map.data.addGeoJson(data);
                        }).catch(console.error);
                    }

                    // Set the grid display style
                    self.$refs.map.data.setStyle({
                        visible: loadFeatures,
                        strokeColor: '#777',
                        strokeWeight: 0.5,
                    });
                });
            },
            codeSelectionHandler() {
                this.$emit('what3words-code-added', {
                    code: this.what3words_code
                });
                this.closeModal();
            }
        }
    }

    function resetData() {
        return {
            error: '',
            what3words_code: false,
            postcode: '',
            address_longitude: null,
            address_latitude: null
        }
    }
</script>


<style scoped>
    .map {
        height:500px;
        width: 100%;
    }
</style>
