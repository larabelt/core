global._ = require('lodash');

export default {
    props: ['route'],
    data() {
        return {
            max: 5
        }
    },
    computed: {
        paginator() {
            return this.$parent.paginator;
        },
        showPager() {
            if (this.paginator == undefined || this.paginator.length == 0) {
                return false;
            }

            return this.paginator.total > this.paginator.per_page;
        },
        isNotFirst() {
            return this.paginator.current_page != 1
        },
        hasNext() {
            return this.paginator.last_page - this.paginator.current_page > 0;
        },
        indexes() {

            let first = this.paginator.current_page;

            let values = [];

            let midpoint = Math.ceil(this.max / 2);

            if (this.paginator.last_page - this.max > 0) {

                if (this.paginator.current_page >= midpoint) {
                    first = this.paginator.current_page - (this.max % midpoint);
                }

                if (this.paginator.last_page - this.paginator.current_page < midpoint) {
                    first = this.paginator.last_page - (this.max - 1)
                }
            }

            if (this.paginator.last_page - this.max <= 0) {
                first = 1;
                this.max = this.paginator.last_page;
            }

            let i = first;
            while (i < first + this.max) {
                values.push(i);
                i++;
            }

            return values;
        },
        hasPrevious() {
            return this.paginator.current_page - 1 > 0;
        },
        hasLast() {
            return this.paginator.current_page != this.paginator.last_page;
        }
    },
    methods: {
        paginate(event, query) {
            event.preventDefault();
            this.$parent.paginate(query);
            if (this.route != undefined) {
                query = _.merge(this.$parent.getUrlQuery(), query);
                this.$parent.$router.push({ name: this.route, query: query})
            }
        },
        isActive(id) {
            return id == this.paginator.current_page;
        }
    },
    template: `
        <div v-if="showPager">
            <div class="row ohio-pagination">
                <div class="col-md-5">
                    <div class="pagination" role="status" aria-live="polite">
                        Showing {{ paginator.from }} to {{ paginator.to }} of {{ paginator.total }} entries
                    </div>
                </div>
                <div class="col-md-7">
                    <span class="pull-right">
                        <ul class="pagination-sm pagination">
                            <li v-if="isNotFirst">
                                <a href="" v-on:click="paginate($event, {page: 1})"><i class="fa fa-step-backward" aria-hidden="true"></i></a>
                            </li>
                            <li v-else class="disabled">
                                <span aria-hidden="true"><i class="fa fa-step-backward" aria-hidden="true"></i></span>
                            </li>
                            <li v-if="hasPrevious">
                                <a href="" v-on:click="paginate($event, {page: paginator.current_page - 1})"><i class="fa fa-backward" aria-hidden="true"></i></a>
                            </li>
                            <li v-else class="disabled">
                                <span aria-hidden="true"><i class="fa fa-backward" aria-hidden="true"></i></span>
                            </li>
                            <template v-for="number in indexes">
                                <li v-bind:class="{ active: isActive(number) }">
                                    <a href="" v-on:click="paginate($event, {page: number})">{{ number }}</a>
                                </li>
                            </template>
                            <li v-if="hasNext">
                                <a href="" v-on:click="paginate($event, {page: paginator.current_page + 1})"><i class="fa fa-forward" aria-hidden="true"></i></a>
                            </li>
                            <li v-else class="disabled">
                                <span aria-hidden="true"><i class="fa fa-forward" aria-hidden="true"></i></span>
                            </li>
                            <li v-if="hasLast">
                                <a href="" v-on:click="paginate($event, {page: paginator.last_page})"><i class="fa fa-step-forward" aria-hidden="true"></i></a>
                            </li>
                            <li v-else class="disabled">
                                <span aria-hidden="true"><i class="fa fa-step-forward" aria-hidden="true"></i></span>
                            </li>
                        </ul>
                    </span>
                </div>
            </div>
        </div>
    `
}