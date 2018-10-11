import baseInput from 'belt/core/js/inputs/shared';
import storeAdapter from 'belt/core/js/translations/store/adapter';
import edit from 'belt/core/js/translations/edit';
import html from 'belt/core/js/translations/inputs/group/template.html';

export default {
    mixins: [baseInput, storeAdapter],
    props: {
        translatable_type: {
            default: function () {
                return this.$parent.entity_type;
            }
        },
        translatable_id: {
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
        let eventKey = this.translatable_type + ':' + this.translatable_id + ':updating';
        Events.$on(eventKey, () => {
            this.update();
        });
    },
    computed: {
        visible() {
            return _.get(this.visibility, this.column, false);
        }
    },
    methods: {
        update() {
            this.eventBus.$emit('update');
            setTimeout(() => {
                this.translationsLoad();
            }, 500);
        },
    },
    components: {
        edit: edit,
    },
    template: html
}