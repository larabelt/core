export default {
    data() {
        return {
            max: 5
        }
    },
    computed: {
        hasLast() {
            if( this.$parent.items.data.current_page != this.$parent.items.data.last_page ) {
                return true;
            }

            return false;
        },
        hasNext() {
            if( this.$parent.items.data.last_page - this.$parent.items.data.current_page > 0 )
            {
                return true;
            }
            return false;
        },
        hasPrevious() {
            if( this.$parent.items.data.current_page - 1 > 0 )
            {
                return true;
            }
            return false;
        },
        indexes() {
            let first = this.results.current_page;
            let values = [];

            let midpoint = Math.ceil( this.max / 2 );

            if ( this.results.last_page - this.max > 0) {

                if ( this.results.current_page >= midpoint ) {
                    first = this.results.current_page - (this.max % midpoint);
                }

                if ( this.results.last_page - this.results.current_page < midpoint ) {
                    first = this.results.last_page - (this.max - 1)
                }
            }

            if ( this.results.last_page - this.max <= 0) {
                first = 1;
                this.max = this.results.last_page;
            }

            let i = first;
            while (i < first + this.max) {
                values.push(i);
                i++;
            }

            return values;
        },
        isNotFirst() {
            if( this.$parent.items.data.current_page == 1 ) {
                return false;
            }

            return true;
        },
        results() {
            return this.$parent.items.data
        }
    },
    methods: {
        getParams(type, number = null) {

            let params = {};
            _(this.$parent.$route.query).forEach((value, key) => {
                params[key] = value;
            });

            if( typeof params['page'] == 'undefined' ) {
                params['page'] = this.results.current_page;
            }

            switch (type) {
                case 'first':
                    params['page'] = 1;
                    break;
                case 'previous':
                    params['page'] = this.results.current_page - 1;
                    break;
                case 'next':
                    params['page'] = this.results.current_page + 1;
                    break;
                case 'last':
                    params['page'] = this.results.last_page;
                    break;
                case 'page':
                    params['page'] = number;
                    break;
            }

            return params;
        },
        isActive(id) {
            if( id == this.results.current_page ) {
                return true;
            }

            return false;
        }
    },
    props: ['routename'],
    template: `
        <ul class="pagination-sm pagination">
            <li v-if="isNotFirst">
                <router-link :to="{ name: routename, query: getParams('first') }">First</router-link>
            </li>
            <li v-if="hasPrevious">
                <router-link :to="{ name: routename, query: getParams('previous') }">Previous</router-link>
            </li>
            <template v-for="number in indexes">
                <li v-bind:class="{ active: isActive(number) }">
                    <router-link :to="{ name: routename, query: getParams('page', number) }">{{ number }}</router-link>
                </li>
            </template>
            <li v-if="hasNext">
                <router-link :to="{ name: routename, query: getParams('next') }">Next</router-link>
            </li>
            <li v-if="hasLast">
                <router-link :to="{ name: routename, query: getParams('last') }">Last</router-link>
            </li>
        </ul>
    `
}