export default {
    data () {
        return {
            number_of_pages: 0,
            page_number: 1,
            total_items: 0
        }
    },
    methods: {
        updatePaginationInfo(e) {
            this.number_of_pages = e.last_page;
            this.page_number = e.page_number;
            this.total_items = e.total_items_count;
            this.$eventHub.$emit('count-updated', this.total_items);
        }
    }
}
