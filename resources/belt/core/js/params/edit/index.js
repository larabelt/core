import Form from 'belt/core/js/params/form';
import TranslationStore from 'belt/core/js/translations/store/adapter';
import html from 'belt/core/js/params/edit/template.html';

export default {
    mixins: [TranslationStore],
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
            entity_type: 'params',
            form: new Form({entity_type: this.$parent.paramable_type, entity_id: this.$parent.paramable_id}),
        }
    },
    computed: {
        dirty() {
            return this.form.dirty('value');
        },
        entity_id() {
            return this.param.id;
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
        translatable_type() {
            return 'params';
        },
        translatable_id() {
            return this.entity_id;
        },
    },
    watch: {
        'param.id': function () {
            this.reset();
        }
    },
    created() {
        this.form.setData(this.param);
    },
    beforeMount() {
        if (_.get(this.config, 'translatable')) {
            this.bootTranslationStore();
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
            Events.$emit('params:' + this.form.id + ':updating', this.form);
            if (this.dirty) {
                this.submit();
            }
        },
        submit() {
            this.form.submit();
        },
    },
    template: html
}