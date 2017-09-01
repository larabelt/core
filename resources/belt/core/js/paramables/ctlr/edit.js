import Form from 'belt/core/js/paramables/form';
import shared from 'belt/core/js/paramables/ctlr/shared';
import html from 'belt/core/js/paramables/templates/edit.html';

export default {
    mixins: [shared],
    props: {
        config: {default: {}},
        param: {default: {}},
    },
    data() {
        return {
            eventBus: this.$parent.eventBus,
            table: this.$parent.table,
            form: new Form({morphable_type: this.morphable_type, morphable_id: this.morphable_id}),
        }
    },
    computed: {
        canDelete() {
            if (!this.config) {
                return true;
            }
            return !_.has(this.config, 'params.' + this.param.key)
        },
        dirty() {
            return this.form.dirty('value');
        },
        options() {
            if (!this.config) {
                return false;
            }
            return _.get(this.config, 'params.' + this.param.key, false);
        }
    },
    mounted() {
        this.eventBus.$on('scan', () => {
            this.scan();
        });
        this.eventBus.$on('update', () => {
            this.update();
        });
        this.form.show(this.param.id);
    },
    methods: {
        scan() {
            if (this.dirty) {
                this.$parent.dirty = true;
            }
        },
        triggerScan() {
            this.$parent.scan();
        },
        update() {
            if (this.dirty) {
                this.form.submit();
            }
        },
    },
    template: html
}