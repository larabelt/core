export default {

    props: {
        route: String,
        paginator: Object,
        column: String,
    },
    computed: {
        paginator() {
            return this.$parent.paginator;
        },
        showSorter() {
            return this.paginator != undefined && this.paginator.total > 1;
        },
    },
    watch: {

    },
    methods: {
        active() {
            return this.column == this.$parent.query.orderBy ? 'active' : '';
        },
        sortBy() {
            let orderBy = this.$parent.query.orderBy;
            let sortBy = this.$parent.query.sortBy;
            if (sortBy == undefined || this.column != orderBy) {
                sortBy = 'asc';
            } else {
                sortBy = sortBy == 'asc' ? 'desc' : 'asc';
            }
            return sortBy;
        },
        paginate(event) {
            let query = this.query();
            event.preventDefault();
            this.$parent.paginate(query);
            if (this.route != undefined) {
                query = _.merge(this.$parent.getUrlQuery(), query);
                this.$parent.$router.push({name: this.route, query: query})
            }
        },
        query() {
            let query = {
                orderBy: this.column,
                sortBy: this.sortBy(),
                page: 1
            };
            return query;
        },
    },

    template: `
        <span v-if="showSorter">
            <span class="belt-column-sorter pull-right" 
                v-bind:class="[active(), sortBy()]">
                <a href="" v-on:click="paginate($event)">
                    <i class="fa fa-arrows-v"></i>
                    <i class="fa fa-sort-amount-asc"></i>
                    <i class="fa fa-sort-amount-desc"></i>
                </a>
            </span>
        </span>
    `
}