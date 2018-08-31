import edit from 'belt/core/js/params/edit';
import html from 'belt/core/js/params/list/custom-group/template.html';

export default {
    props: {
        params: {
            default: function () {
                return [];
            }
        },
        prefix: {
            default: function () {
                return [];
            }
        }
    },
    data() {
        return {
            eventBus: this.$parent.eventBus,
            paramable_type: this.$parent.paramable_type,
            paramable_id: this.$parent.paramable_id,
        }
    },
    computed: {},
    mounted() {

    },
    methods: {
        param(key) {
            return _.find(this.params, {key: key});
        },
        paramConfig(key) {
            return _.get(this.param(key), 'config', {});
        },
    },
    components: {
        edit: edit,
    },
    template: html
}