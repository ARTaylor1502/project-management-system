export default {
    data() {
      return {
          departments: []
      }
    },
    methods: {
        loadDepartments() {
            let self = this;

            axios.get(this.$route('api.department.list'))
            .then(response => {
                response.data.forEach(function(department) {
                    self.departments.push(department);
                });
            }).catch(function (error) {
                console.log(error);
            });
        }
    }
}
