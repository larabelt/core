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
            template: index_html,
        },
    },

    template: `
        <div>
            <heading>
                <span slot="title">User Manager</span>
                <span slot="help"><link-help docKey="admin.core.users.manager" /></span>
                <li><router-link :to="{ name: 'users' }">User Manager</router-link></li>
            </heading>
            <section class="content">
                <index></index>
            </section>
        </div>
        `
}