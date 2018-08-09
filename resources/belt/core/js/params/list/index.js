import storeAdapter from 'belt/core/js/params/store/adapter';
import group from 'belt/core/js/params/list/group';
import edit from 'belt/core/js/params/edit';
import html from 'belt/core/js/params/list/template.html';

export default {
    mixins: [storeAdapter],
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
            eventBus: new Vue(),
        }
    },
    created() {
        let eventKey = this.paramable_type + ':' + this.paramable_id + ':updating';
        Events.$on(eventKey, () => {
            this.update();
        });
    },
    computed: {
        groups() {
            return _.get(this.paramConfigs, 'groups', []);
        },
        sortedParams() {
            //let sorted = [];
            let configs = _.get(this.paramConfigs, 'params');
            let sorted = {};
            _.forEach(configs, (config, paramKey) => {
                console.log(paramKey);
                let param = _.find(this.params, {key: paramKey});
                if (param) {
                    let groupKey = _.get(config, 'group', 'not-a-group-' + param.id);
                    param.config = config;
                    _.set(sorted, groupKey + '.' + paramKey, param);
                }
            });
            return sorted;
        },
    },
    methods: {
        isGroup(key) {
            return !key.includes('not-a-group');
            return isNaN(parseFloat(key)) && !isFinite(key);
        },
        group(key) {
            return _.get(this.groups, key);
        },
        update() {
            this.eventBus.$emit('update');
        },
    },
    components: {
        group,
        edit: edit,
    },
    template: html
}