import Form from 'belt/core/js/params/form';
import html from 'belt/core/js/params/edit/template.html';

export default {
    props: {
        config: {
            default: function () {
                return {};
            }
        },
        param: {
            default: function () {
                return {};
            }
        },
    },
    data() {
        return {
            form: new Form({entity_type: this.$parent.paramable_type, entity_id: this.$parent.paramable_id}),
        }
    },
    computed: {
        dirty() {
            return this.form.dirty('value');
        },
        eventBus() {
            return this.$parent.eventBus;
        },
        componentKey() {
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
        Events.$on('update-params', this.update);
        this.reset();
    },
    destroyed() {
        Events.$off('update-params', this.update);
    },
    methods: {
        reset() {
            this.form.reset();
            this.form.setData(this.param);
        },
        update() {
            if (this.dirty) {
                this.form.submit();
            }
        },
    },
    template: html
}