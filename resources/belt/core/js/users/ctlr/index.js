// helpers
import Table from 'belt/core/js/users/table';

// templates make a change

import index_html from 'belt/core/js/users/templates/index.html';

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
                <span slot="title">User Manager</span>
            </heading>
            <section class="content">
                <index></index>
            </section>
        </div>
        `
}