import shared from 'belt/core/js/paramables/ctlr/shared';
import edit from 'belt/core/js/paramables/ctlr/edit';
import html from 'belt/core/js/paramables/templates/index.html';

export default {
    mixins: [shared],
    props: {
        paramable_type: {
            default: function () {
                return this.$parent.entity_type;
            }
        },
        paramable_id: {
            default: function () {
                return this.$parent.entity_id;
            }
        },
    },
    data() {
        return {
            dirty: false,
            eventBus: new Vue(),
        }
    },
    computed: {
        config() {
            return this.$store.getters[this.storeKey + '/config/data'];
        },
        params() {
            let configs = this.getConfig('params');
            let params = this.$store.getters[this.storeKey + '/params/data'];
            let _params = [];
            _.forEach(configs, function (config, key) {
                let param = _.find(params, {key: key});
                if (param) {
                    _params.push(param);
                }
            });
            return _params;
        },
        storeKey() {
            return this.paramable_type + this.paramable_id;
        },
    },
    methods: {
        getConfig(key, defaultValue) {
            let config = this.config ? this.config : {};
            let value = _.get(config, key);
            return value ? value : defaultValue;
        },
        scan() {
            this.dirty = false;
            this.eventBus.$emit('scan');
        },
        update() {
            this.eventBus.$emit('update');
            this.dirty = false;
        }
    },
    components: {
        edit: edit,
    },
    template: html
}