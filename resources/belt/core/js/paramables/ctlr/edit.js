import Form from 'belt/core/js/paramables/form';
import shared from 'belt/core/js/paramables/ctlr/shared';
import html from 'belt/core/js/paramables/templates/edit.html';

export default {
    mixins: [shared],
    props: {
        config: {
            default: function () {
                return {};
            }
        },
        param: {default: {}},
    },
    data() {
        return {
            eventBus: this.$parent.eventBus,
            form: new Form({morphable_type: this.$parent.paramable_type, morphable_id: this.$parent.paramable_id}),
        }
    },
    computed: {
        hasConfig() {
            return !_.isEmpty(this.config);
        },
        dirty() {
            return this.form.dirty('value');
        },
        inputType() {
            let type = _.get(this.config, 'type');
            if (!type) {
                type = this.options.length ? 'select' : 'text';
            }
            return 'input-' + type;
        },
        options() {
            let options = [];
            let config = _.get(this.config, 'options', {});
            if (!_.isEmpty(config)) {
                _.forIn(config, function (value, key) {
                    options.push({
                        value: key,
                        label: value,
                    });
                });
                options = _.orderBy(options, ['label']);
            }
            return options;
        },
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