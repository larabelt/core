export default {

    props: {
        column: String,
    },
    data() {
        return {
            'table': this.$parent.table,
        };
    },
    computed: {
        show() {
            return this.table != undefined && this.table.total > 1;
        },
        title() {
            if (this.active() && 'desc' == this.sortBy()) {
                return 'reverse sort by ' + this.column;
            }

            return 'sort by ' + this.column;
        },
    },
    methods: {
        active() {
            return this.column == this.table.getQuery('orderBy') ? 'active' : '';
        },
        paginate() {
            this.table.updateQuery(this.query());
            this.table.index();
            if (this.table.router) {
                this.table.router.push({query: this.table.getQuery()});
            }
            if (this.table.name) {
                History.set(this.table.name, 'table.query.orderBy', this.table.query.orderBy);
                History.set(this.table.name, 'table.query.sortBy', this.table.query.sortBy);
                History.set(this.table.name, 'table.query.page', this.table.query.page);
            }
        },
        sortBy() {
            if (this.column == this.table.getQuery('orderBy') && this.table.getQuery('sortBy') == 'asc') {
                return 'desc';
            }
            return 'asc';
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
            <span class="belt-column-sorter pull-right" :class="[active(), sortBy()]">
                <a href="" @click.prevent="paginate($event)" :title="title">
                    <i class="fa fa-arrows-v"></i>
                    <i class="fa fa-sort-amount-asc"></i>
                    <i class="fa fa-sort-amount-desc"></i>
                </a>
            </span>
        </span>
    `
}