// helpers
import Table from 'belt/core/js/roles/table';

// templates make a change
import heading_html from 'belt/core/js/templates/heading.html';
import html from 'belt/core/js/roles/list/template.html';

export default {

    components: {
        heading: {template: heading_html},
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
            template: html,
        },
    },

    template: `
        <div>
            <heading>
                <span slot="title">Role Manager</span>
            </heading>
            <section class="content">
                <index></index>
            </section>
        </div>
        `
}