import Table from 'belt/core/js/work-requests/table';
import listItem from 'belt/core/js/work-requests/list-workable/list-item';
import html from 'belt/core/js/work-requests/list-workable/template.html';

/**
 * various config/text data
 * buttons that advance the workflow
 * POST to work-requests api... do stuff on Team/etc
 * fire event that reloads team
 * roles/abilities that otherwise block workflow
 */

export default {
    props: {
        morphable_id: {
            default: function () {
                return this.$parent.morphable_id;
            }
        },
        morphable_type: {
            default: function () {
                return this.$parent.morphable_type;
            }
        },
    },
    data() {
        return {
            table: new Table({router: this.$router}),
        }
    },
    computed: {
        show() {
            return this.table.items.length;
        },
    },
    mounted() {
        this.table.updateQuery({
            is_open: true,
            workable_id: this.morphable_id,
            workable_type: this.morphable_type,
        });
        this.table.index();
    },
    components: {
        listItem,
    },
    template: html,
}