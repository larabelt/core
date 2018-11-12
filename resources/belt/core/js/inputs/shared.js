export default {
    props: {
        config: {
            default: function () {
                return this.$parent.config;
            }
        },
        column: {
            default: function () {
                return this.$parent.column;
            }
        },
        description: {
            default: function () {
                return '';
            }
        },
        form: {
            default: function () {
                return this.$parent.form;
            }
        },
        placeholder: {
            default: function () {
                return '';
            }
        },
        required: {default: false},
        table: {
            default: function () {
                return this.$parent.table;
            }
        },
    },
    data() {
        return {};
    },
    computed: {
        _description() {
            return this.description ? this.description : this.getConfig('description');
        },
        entity_type() {
            return this.form.morph_class;
        },
        entity_id() {
            return this.form.id;
        },
        label() {
            return this.getConfig('label');
        },
        parentUpdateEvent() {
            return this.entity_type + ':' + this.entity_id + ':updating';
        },
        _placeholder() {
            let placeholder = this.getConfig('placeholder');
            return placeholder ? placeholder : this.placeholder;
        },
        value() {
            return this.form[this.column];
        },
    },
    methods: {
        getConfig(key, defaultValue) {
            let config = this.config ? this.config : {};
            let value = _.get(config, key);
            return value ? value : defaultValue;
        },
        emitEvent(payload) {
            this.$emit('input-updated', payload);
        }
    },
}