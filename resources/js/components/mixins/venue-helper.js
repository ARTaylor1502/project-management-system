export default {
    methods: {
        loadVenues() {
            this.venues = [];

            axios.get(this.$route('api.venue.list'))
                .then(response => {
                    response.data.forEach((venue) => {
                        this.venues.push(venue);
                    });
                }).catch(function (error) {
                console.log(error);
            });
        },
    }
}
