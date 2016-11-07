export default {

    computed: {
        active() {
            let route_order = this.$parent.$route.query.orderBy;
            if (typeof route_order !== 'undefined' && route_order == this.orderBy) {
                return 'active';
            }
            return '';
        },
        params() {
            let value = {
                orderBy: this.orderBy,
                sortBy: this.sortBy,
                page: 1
            };
            return value;
        },
        sortBy() {
            let route_order = this.$parent.$route.query.orderBy;
            let route_sort = this.$parent.$route.query.sortBy;
            if (typeof route_sort !== 'undefined' && typeof route_order !== 'undefined') {
                if (this.$parent.$route.query.sortBy == 'asc' && route_order == this.orderBy) {
                    return 'desc';
                }
            }
            return 'asc';
        }
    },

    props: ['orderBy', 'routename'],

    template: `
        <span class="ohio-column-sorter pull-right" 
                v-bind:class="[active, sortBy]"
                v-bind:order-by="orderBy">
            <router-link v-bind:to="{ name: routename, query: { orderBy: params.orderBy, sortBy: params.sortBy, page: params.page } }">
                <i class="fa fa-arrows-v"></i>
                <i class="fa fa-sort-amount-asc"></i>
                <i class="fa fa-sort-amount-desc"></i>
            </router-link>
        </span>
    `
}