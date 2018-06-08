import storeAdapter from 'belt/core/js/params/store/adapter';
import edit from 'belt/core/js/params/edit';
import html from 'belt/core/js/params/list/template.html';

export default {
    mixins: [storeAdapter],
    props: {
        paramable_type: {
            default: function () {
                return this.$parent.morphable_type;
            }
        },
        paramable_id: {
            default: function () {
                return this.$parent.morphable_id;
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
            let sorted = [];
            _.forEach(this.paramConfigs, (config, key) => {
                let param = _.find(this.params, {key: key});
                if (param) {
                    param.config = config;
                    sorted.push(param);
                }
            });
            return sorted;
        },
    },
    methods: {
        update() {
            this.eventBus.$emit('update');
        },
    },
    components: {
        edit: edit,
    },
    template: html
}