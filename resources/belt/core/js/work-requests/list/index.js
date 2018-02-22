import Table from 'belt/core/js/work-requests/table';
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
            components: {
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