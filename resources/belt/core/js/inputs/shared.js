export default {
    props: {
        config: {
            default: function () {
                return this.$parent.config;
            }
        },
        column: {default: ''},
        form: {
            default: function () {
                return this.$parent.form;
            }
        },
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
        label() {
            return this.getConfig('label');
        },
        placeholder() {
            return this.getConfig('placeholder');
        },
        value() {
            return this.form[this.column];
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