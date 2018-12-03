import Form from 'belt/core/js/params/form';
import store from 'belt/core/js/params/store';

export default {
    props: {
        paramable: {
            default: function () {
                return this.$parent.form;
            }
        },
    },
    data() {
        return {
            paramsLoading: false,
        }
    },
    created() {
        if (!this.$store.state[this.paramStoreKey]) {
            this.$store.registerModule(this.paramStoreKey, store);
            this.$store.dispatch(this.paramStoreKey + '/set', {entity_type: this.paramable_type, entity_id: this.paramable_id});
            this.paramsLoad();
        }
    },
    watch: {
        'paramable.id': function () {
            this.paramsLoad();
        }
    },
    computed: {
        params() {
            return this.$store.getters[this.paramStoreKey + '/data'];
        },
        paramConfigs() {
            return this.$store.getters[this.paramStoreKey + '/config'];
        },
        paramStoreKey() {
            return 'params/' + this.paramable_type + this.paramable_id;
        },
    },
    methods: {
        paramsLoad() {
            this.paramsLoading = true;
            let params = _.get(this.paramable, 'params', []);
            if (params.length) {
                this.$store.dispatch(this.paramStoreKey + '/config', _.get(this.paramable, 'config', {}));
                this.$store.dispatch(this.paramStoreKey + '/data', []);
                this.$store.dispatch(this.paramStoreKey + '/pushParams', params)
                    .then(() => {
                        this.paramsLoading = false;
                    });
            } else {
                this.$store.dispatch(this.paramStoreKey + '/load')
                    .then(() => {
                        this.paramsLoading = false;
                    });
            }
        },
    }
}