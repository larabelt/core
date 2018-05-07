import storeMixin from 'belt/core/js/roles/edit/store/mixin';
import mixin from 'belt/core/js/roles/edit/mixin';
import abilities from 'belt/core/js/abilities/list';

export default {
    mixins: [storeMixin, mixin],
    mounted() {
        this.$store.dispatch(this.storeKey + '/permissions/load');
    },
    components: {
        edit: abilities
    },
}