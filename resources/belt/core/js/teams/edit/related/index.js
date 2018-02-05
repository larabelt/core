import edit from 'belt/core/js/teams/edit/shared';
import Table from 'belt/core/js/teams/edit/related/table';
import html from 'belt/core/js/teams/edit/related/template.html';

export default {
    mixins: [edit],
    components: {
        edit: {
            data() {
                return {
                    table: new Table({
                        morphable_type: 'teams',
                        morphable_id: this.$parent.morphable_id,
                    }),
                }
            },
            mounted() {
                this.table.index();
            },
            methods: {},
            template: html
        },
    },
}