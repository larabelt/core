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
        active() {

            let orderBy = this.$parent.query.orderBy;

            if (orderBy == undefined || this.column != orderBy) {
                return ''
            }

            return 'active';
        },
        sortBy() {
            return this.getSortBy();
        },
        query() {
            let query = {
                orderBy: this.column,
                sortBy: this.getSortBy(),
                page: 1
            };
            return query;
        },
    },
    methods: {
        getSortBy() {
            let orderBy = this.$parent.query.orderBy;
            let sortBy = this.$parent.query.sortBy;

            if (sortBy == undefined || this.column != orderBy) {
                sortBy = 'asc';
            } else {
                sortBy = sortBy == 'asc' ? 'desc' : 'asc';
            }

            return sortBy;
        },
        paginate(event, query) {
            event.preventDefault();
            this.$parent.paginate(query);
            if (this.route != undefined) {
                query = _.merge(this.$parent.getUrlQuery(), query);
                this.$parent.$router.push({name: this.route, query: query})
            }
        },
    },

    template: `
        <span v-if="showSorter">
            <span class="ohio-column-sorter pull-right" 
                v-bind:class="[active, sortBy]">
                <a href="" v-on:click="paginate($event, query)">
                    <i class="fa fa-arrows-v"></i>
                    <i class="fa fa-sort-amount-asc"></i>
                    <i class="fa fa-sort-amount-desc"></i>
                </a>
            </span>
        </span>
    `
}