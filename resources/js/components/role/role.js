import columnSorter from '../column-sorter';
import pagination from '../pagination';

import template_index from './templates/index';

export default {

    components: {
        'column-sorter': columnSorter,
        pagination: pagination
    },

    template: template_index,

    data() {
        return {
            items: {
                uri: '/admin/ohio/core/roles',
                slug: 'roles',
                columns: [
                    {
                        title: 'ID',
                        slug: 'id'
                    },
                    {
                        title: 'Name',
                        slug: 'name'
                    },
                    {
                        title: 'Slug',
                        slug: 'slug'
                    }
                ],
                data: []
            }
        }
    },

    mounted() {
        this.getItems();
    },

    methods: {
        getItems() {
            let params = {};
            _(this.$route.query).forEach((value, key) => {
                params[key] = value;
            });

            let url = '/api/v1/roles?' + $.param(params);

            this.$http.get(url).then(function (response) {
                this.items.data = response.data;

            }, function (response) {
                console.log('Error');
            });
        },
        destroy(id) {
            this.$http.delete('/api/v1/roles/' + id).then(function(response){
                if( response.status == 204 ) {
                    this.getItems();
                }
            });
        }
    },

    watch: {
        '$route' (to, from) {
            this.getItems();
        }
    }
}