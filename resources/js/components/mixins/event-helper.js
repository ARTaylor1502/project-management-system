export default {
    data() {
      return {
          events: []
      }
    },
    methods: {
        loadEvents(filters) {
            let url = '/api/event', self = this;

            if(filters !== undefined) {
                let count = 0;

                for (var key in filters) {
                    if (filters.hasOwnProperty(key)) {
                        if(count === 0) {
                            url += '?';
                        } else {
                            url += '&';
                        }

                        url += key + '=' + filters[key];
                        count++;
                    }
                }
            }

            axios.get(url)
            .then(response => {
                response.data.forEach(function(event) {
                    self.events.push(event);
                });
            }).catch(function (error) {
                console.log(error);
            });
        },
    }
}
