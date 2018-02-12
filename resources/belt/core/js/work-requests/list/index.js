import Table from 'belt/core/js/work-requests/table';
import datetime from 'belt/core/js/mixins/datetime';
import heading_html from 'belt/core/js/templates/heading.html';
import html from 'belt/core/js/work-requests/list/template.html';

export default {

    components: {
        heading: {template: heading_html},
        index: {
            mixins: [datetime],
            data() {
                return {
                    table: new Table({router: this.$router}),
                }
            },
            mounted() {
                this.table.updateQueryFromRouter();
                this.table.index();
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