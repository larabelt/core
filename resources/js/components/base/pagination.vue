<template>
    <div v-if="show">
        <div class="row belt-pagination">
            <div class="col-md-4">
                <div class="pagination" role="status" aria-live="polite">
                    Showing {{ table.from }} to {{ table.to }} of {{ table.total }} entries
                </div>
            </div>
            <div class="col-md-8">
                <span class="pull-right">
                    <ul class="pagination-sm pagination">
                        <li v-if="isNotFirst">
                            <a href="" @click.prevent="paginate({page: 1})"><i class="fa fa-step-backward" aria-hidden="true"></i></a>
                        </li>
                        <li v-else class="disabled">
                            <span aria-hidden="true"><i class="fa fa-step-backward" aria-hidden="true"></i></span>
                        </li>
                        <li v-if="hasPrevious">
                            <a href="" @click.prevent="paginate({page: table.current_page - 1})"><i class="fa fa-backward" aria-hidden="true"></i></a>
                        </li>
                        <li v-else class="disabled">
                            <span aria-hidden="true"><i class="fa fa-backward" aria-hidden="true"></i></span>
                        </li>
                        <template v-for="number in indexes">
                            <li :class="{ active: isActive(number) }">
                                <a href="" @click.prevent="paginate({page: number})">{{ number }}</a>
                            </li>
                        </template>
                        <li v-if="hasNext">
                            <a href="" @click.prevent="paginate({page: table.current_page + 1})"><i class="fa fa-forward" aria-hidden="true"></i></a>
                        </li>
                        <li v-else class="disabled">
                            <span aria-hidden="true"><i class="fa fa-forward" aria-hidden="true"></i></span>
                        </li>
                        <li v-if="hasLast">
                            <a href="" @click.prevent="paginate({page: table.last_page})"><i class="fa fa-step-forward" aria-hidden="true"></i></a>
                        </li>
                        <li v-else class="disabled">
                            <span aria-hidden="true"><i class="fa fa-step-forward" aria-hidden="true"></i></span>
                        </li>
                    </ul>
                </span>
                <span class="pull-right">
                    <div class="form-group">
                        <select class="form-control" v-model="table.query.perPage" @change="table.index()">
                            <template v-for="perPage in perPages">
                                <option :value="perPage">{{ perPage }}</option>
                            </template>
                        </select>
                    </div>
                </span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
    data() {
        return {
            max: 5,
            perPages: [10, 50, 100, 500, 1000],
        }
    },
    computed: {
        table() {
            return this.$parent.table;
        },
        show() {
            if (this.table == undefined || this.table.length == 0) {
                return false;
            }

            return this.table.total > 50 || this.table.total > this.table.per_page;
        },
        isNotFirst() {
            return this.table.current_page != 1
        },
        hasNext() {
            return this.table.last_page - this.table.current_page > 0;
        },
        indexes() {

            let first = this.table.current_page;

            let values = [];

            let midpoint = Math.ceil(this.max / 2);

            if (this.table.last_page - this.max > 0) {

                if (this.table.current_page >= midpoint) {
                    first = this.table.current_page - (this.max % midpoint);
                }

                if (this.table.last_page - this.table.current_page < midpoint) {
                    first = this.table.last_page - (this.max - 1)
                }
            }

            if (this.table.last_page - this.max <= 0) {
                first = 1;
                this.max = this.table.last_page;
            }

            let i = first;
            while (i < first + this.max) {
                values.push(i);
                i++;
            }

            return values;
        },
        hasPrevious() {
            return this.table.current_page - 1 > 0;
        },
        hasLast() {
            return this.table.current_page != this.table.last_page;
        }
    },
    methods: {
        paginate(query) {
            this.table.updateQuery(query);
            this.table.index();
            if (this.table.router) {
                this.table.router.push({query: this.table.getQuery()});
            }
        },
        isActive(id) {
            return id == this.table.current_page;
        }
    }
}

</script>