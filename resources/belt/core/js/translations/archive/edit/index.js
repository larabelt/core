import Form from 'belt/core/js/translations/form';
import html from 'belt/core/js/translations/edit/template.html';

export default {
    props: {
        config: {
            default: function () {
                return {};
            }
        },
        translation: {
            default: function () {
                return {};
            }
        },
    },
    data() {
        return {
            eventBus: this.$parent.eventBus,
            form: new Form({entity_type: this.$parent.translatable_type, entity_id: this.$parent.translatable_id}),
        }
    },
    computed: {
        dirty() {
            return this.form.dirty('value');
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
        'translation.id': function () {
            this.reset();
        }
    },
    mounted() {
        this.eventBus.$on('update', () => {
            this.update();
        });
        this.reset();
    },
    methods: {
        reset() {
            this.form.reset();
            this.form.setData(this.translation);
        },
        update() {
            if (this.dirty) {
                this.form.submit();
            }
        },
    },
    template: html
}