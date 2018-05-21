// helpers
import Table from 'belt/core/js/roles/table';

// templates make a change

import html from 'belt/core/js/roles/list/template.html';

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
            template: html,
        },
    },

    template: `
        <div>
            <heading>
                <span slot="title">Role Manager</span>
                <li><router-link :to="{ name: 'roles' }">Role Manager</router-link></li>
            </heading>
            <section class="content">
                <index></index>
            </section>
        </div>
        `
}