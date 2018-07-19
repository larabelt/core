import edit from 'belt/core/js/teams/edit/shared';
import filterSearch from 'belt/core/js/inputs/filter-search';
import filterType from 'belt/core/js/teams/edit/related/filters/type';
import Table from 'belt/core/js/teams/edit/related/table';
import rowItem from 'belt/core/js/teams/edit/related/row-item';
import html from 'belt/core/js/teams/edit/related/template.html';

export default {
    mixins: [edit],
    components: {
        edit: {
            props: {
                entity_type: {
                    default: function () {
                        return this.$parent.entity_type;
                    }
                },
                entity_id: {
                    default: function () {
                        return this.$parent.entity_id;
                    }
                },
            },
            data() {
                return {
                    table: new Table({
                        entity_type: 'teams',
                        entity_id: this.entity_id,
                    }),
                }
            },
            mounted() {
                this.table.index();
            },
            methods: {
                filter: _.debounce(function (query) {
                    if (query) {
                        query.page = 1;
                        this.table.updateQuery(query);
                    }
                    this.table.index()
                        .then(() => {
                            this.table.pushQueryToHistory();
                            this.table.pushQueryToRouter();
                        });
                }, 300),
            },
            components: {
                filterSearch,
                filterType,
                rowItem,
            },
            template: html
        },
    },
}