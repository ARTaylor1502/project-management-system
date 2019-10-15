<template>
    <div class="list-container">
        <div class="list-header">
            <h3>Ready to Print <span class="badge">{{artwork.length}}</span></h3>
        </div>
        <div v-if="artwork.length > 0" class="list-group list-group-striped">
            <div v-for="(a,key) in artwork" class="list-group-item">
                <div class="row">
                    <div class="offset-sm-2 col-sm-4 mr-5">
                        <div class="artwork-preview">
                            <img class="preview" :src="a.src"/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <h3>{{a.name}} {{a.print_code}}</h3>
                        <h4 v-if="a.material !== null">Material: {{a.material}}</h4>
                        <h4>Size: W {{a.height}}mm x H {{a.width}}mm x D {{a.depth}}mm</h4>
                        <h4>Description: {{a.description}}</h4>
                        <label :for="'artwork_location_concept' + key" class="col-form-label">Artwork Location:</label>
                        <div v-if="a.artwork_url" class="cta-container">
                            <strong>Link to artwork:</strong>
                            <a :href="a.artwork_url">{{a.artwork_url}}</a>
                        </div>
                        <p v-else>No link to artwork found</p>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="list-group list-group-striped mb-0">
            <div class="list-group-item">No artwork currently ready for print</div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "print-tab",
        props: ['project_id', 'artwork'],
    }
</script>
