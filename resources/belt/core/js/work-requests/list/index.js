import Table from 'belt/core/js/work-requests/table';
import datetime from 'belt/core/js/mixins/datetime';
import html from 'belt/core/js/work-requests/list/template.html';

export default {

    components: {
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
            <section class="content">
                <index></index>
            </section>
        </div>
        `
}