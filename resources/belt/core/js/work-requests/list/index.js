import Table from 'belt/core/js/work-requests/table';
import filterSearch from 'belt/core/js/inputs/filter-search';
import filterType from 'belt/core/js/work-requests/list/filters/type';
import listItem from 'belt/core/js/work-requests/list/list-item';
import html from 'belt/core/js/work-requests/list/template.html';

export default {

    components: {
        index: {
            data() {
                return {
                    table: new Table({router: this.$router}),
                }
            },
            mounted() {
                this.table.updateQueryFromRouter();
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
                listItem,
            },
            template: html,
        },
    },

    template: `
        <div>
            <heading>
                <span slot="title">Work Request Manager</span>
            </heading>
            <section class="content">
                <index></index>
            </section>
        </div>
        `
}