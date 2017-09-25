import shared from 'belt/core/js/paramables/ctlr/shared';
import edit from 'belt/core/js/paramables/ctlr/edit';
import html from 'belt/core/js/paramables/templates/index.html';

export default {
    mixins: [shared],
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
            dirty: false,
            eventBus: new Vue(),
        }
    },
    computed: {
        config() {
            return this.$store.getters[this.storeKey + '/config/data'];
        },
        params() {
            return this.$store.getters[this.storeKey + '/params/data'];
        },
        storeKey() {
            return this.paramable_type + this.paramable_id;
        },
    },
    methods: {
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