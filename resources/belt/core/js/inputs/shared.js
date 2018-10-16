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
        form: {
            default: function () {
                return this.$parent.form;
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
        description() {
            return this.getConfig('description');
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
        placeholder() {
            return this.getConfig('placeholder');
        },
        value() {
            return this.form[this.column];
        },
        translatable() {
            return this.form.id ? Vue.prototype.translatable(this.form, this.column) : false;
        }
    },
    created() {
        // // set dynamic form watcher
        // this.$watch('form.' + this.column, function (newValue) {
        //
        // });
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