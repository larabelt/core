import Form from 'belt/core/js/paramables/form';
import shared from 'belt/core/js/paramables/ctlr/shared';
import html from 'belt/core/js/paramables/templates/edit.html';

export default {
    mixins: [shared],
    props: {
        param: {default: {}},
    },
    data() {
        return {
            eventBus: this.$parent.eventBus,
            form: new Form({morphable_type: this.$parent.paramable_type, morphable_id: this.$parent.paramable_id}),
        }
    },
    computed: {
        config() {
            return this.$parent.config;
        },
        dirty() {
            return this.form.dirty('value');
        },
        options() {

            let params = this.config ? _.get(this.config, 'params.' + this.param.key, false) : false;
            let options = [];
            _.forIn(params, function (value, key) {
                options.push({
                    value: key,
                    label: value,
                });
            });
            options = _.orderBy(options, ['label']);

            return options;
        }
    },
    watch: {
        'param.id': function () {
            this.reset();
        }
    },
    mounted() {
        this.eventBus.$on('scan', () => {
            this.scan();
        });
        this.eventBus.$on('update', () => {
            this.update();
        });
        this.reset();
    },
    methods: {
        reset() {
            this.form.reset();
            this.form.setData(this.param);
        },
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