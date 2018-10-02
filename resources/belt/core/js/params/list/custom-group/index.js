import edit from 'belt/core/js/params/edit';
import html from 'belt/core/js/params/list/custom-group/template.html';

export default {
    props: {
        params: {
            default: function () {
                return [];
            }
        },
    },
    data() {
        return {
            eventBus: this.$parent.eventBus,
            paramable_type: this.$parent.paramable_type,
            paramable_id: this.$parent.paramable_id,
        }
    },
    computed: {
        prefix() {
            for (let key in this.params) {
                if (key.substring(0, 5) == 'hero_') {
                    return 'hero_';
                }
                ;
                return '';
            }
            return '';
        }
    },
    mounted() {

    },
    methods: {
        param(key) {
            return _.find(this.params, {key: this.prefixedKey(key)});
        },
        paramConfig(key) {
            return _.get(this.param(key), 'config', {});
        },
        prefixedKey(key) {
            return this.prefix + key;
        },
    },
    components: {
        edit: edit,
    },
    template: html
}