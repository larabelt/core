export default {

    props: {
        column: String,
    },
    computed: {
        show() {
            return this.table != undefined && this.table.total > 1;
        },
        table() {
            return this.$parent.table;
        },
    },
    methods: {
        active() {
            return this.column == this.table.getQuery('orderBy') ? 'active' : '';
        },
        sortBy() {
            if (this.column == this.table.getQuery('orderBy') && this.table.getQuery('sortBy') == 'asc') {
                return 'desc';
            }

            return 'asc';
        },
        paginate() {
            this.table.updateQuery(this.query());
            this.table.index();
            if (this.table.router) {
                this.table.router.push({query: this.table.getQuery()});
            }
        },
        query() {
            return {
                orderBy: this.column,
                sortBy: this.sortBy(),
                page: 1
            };
        },
    },

    template: `
        <span v-if="show">
            <span class="ohio-column-sorter pull-right" :class="[active(), sortBy()]">
                <a href="" @click.prevent="paginate($event)">
                    <i class="fa fa-arrows-v"></i>
                    <i class="fa fa-sort-amount-asc"></i>
                    <i class="fa fa-sort-amount-desc"></i>
                </a>
            </span>
        </span>
    `
}