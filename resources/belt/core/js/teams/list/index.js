import Table from 'belt/core/js/teams/table';

import index_html from 'belt/core/js/teams/list/template.html';

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
            template: index_html,
        },
    },

    template: `
        <div>
            <heading>
                <span slot="title">{{ trans('belt-core::teams.label') }} Manager</span>
            </heading>
            <section class="content">
                <index></index>
            </section>
        </div>
        `
}