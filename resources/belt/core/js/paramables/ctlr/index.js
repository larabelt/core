import Config from 'belt/core/js/paramables/config';
import Table from 'belt/core/js/paramables/table';
import shared from 'belt/core/js/paramables/ctlr/shared';
import create from 'belt/core/js/paramables/ctlr/create';
import edit from 'belt/core/js/paramables/ctlr/edit';
import html from 'belt/core/js/paramables/templates/index.html';

export default {
    mixins: [shared],
    props: {
        morphable: {default: null},
    },
    data() {
        return {
            config: {},
            paramable: this.morphable,
            detached: new Table({
                morphable_type: this.morphable_type,
                morphable_id: this.morphable_id,
                query: {not: 1},
            }),
            table: new Table({
                morphable_type: this.morphable_type,
                morphable_id: this.morphable_id,
            }),
        }
    },
    computed: {
        canCreateParams() {
            return _.get(this.config, 'data.can_create_params', true);
        }
    },
    watch: {
        'paramable.id': function (new_paramable_id) {
            if (new_paramable_id) {
                this.config = new Config({type: this.paramable.type, template: this.paramable.template});
                this.config.load()
                    .then((response) => {
                    
                    });
            }
        }
    },
    mounted() {
        this.table.index();
    },
    methods: {},
    components: {
        create: create,
        edit: edit,
    },
    template: html
}