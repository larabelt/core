import storeAdapter from 'belt/core/js/params/store/adapter';
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
        sortedParams() {
            //let sorted = [];
            let sorted = {};
            _.forEach(this.paramConfigs, (config, key) => {
                let param = _.find(this.params, {key: key});
                let group = _.get(config, 'group', 'default');
                if (param) {
                    param.config = config;
                    //sorted.push(param);
                    _.set(sorted, group + '.' + key, param);
                }
            });
            return sorted;
        },
    },
    methods: {
        groupClose(index, param) {

            let prevParam = this.prevParam(index);
            let nextParam = this.nextParam(index);

            let prevGroup = _.get(prevParam, 'config.group');
            let nextGroup = _.get(nextParam, 'config.group');
            let group = _.get(param, 'config.group');

            if (group && group != nextGroup) {
                return true;
            }

            return false;
        },
        groupOpen(index, param) {

            let prevParam = this.prevParam(index);
            let nextParam = this.nextParam(index);

            let prevGroup = _.get(prevParam, 'config.group');
            let nextGroup = _.get(nextParam, 'config.group');
            let group = _.get(param, 'config.group');

            if (group && group != prevGroup) {
                return true;
            }

            return false;
        },
        nextParam(index) {

            let nextParam = null;
            let nextIndex = this.sortedParams.length > index + 1 ? index + 1 : null;
            if (nextIndex != null) {
                nextParam = _.nth(this.sortedParams, nextIndex);
            }

            return nextParam;
        },
        prevParam(index) {

            let prevParam = null;
            let prevIndex = index > 0 ? index - 1 : null;
            if (prevIndex != null) {
                prevParam = _.nth(this.sortedParams, prevIndex);
            }

            return prevParam;
        },
        update() {
            this.eventBus.$emit('update');
        },
    },
    components: {
        edit: edit,
    },
    template: html
}