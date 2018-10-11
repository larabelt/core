import Form from 'belt/core/js/translations/form';
import store from 'belt/core/js/translations/store';

export default {
    data() {
        return {
            loading: false,
        }
    },
    created() {
        if (!this.$store.state[this.storeKey]) {
            this.$store.registerModule(this.storeKey, store);
        }
        this.$store.dispatch(this.storeKey + '/set', {entity_type: this.translatable_type, entity_id: this.translatable_id});
        //this.translationsLoad();
    },
    computed: {
        translations() {
            return this.$store.getters[this.storeKey + '/data'];
        },
        translationConfigs() {
            return this.$store.getters[this.storeKey + '/config'];
        },
        storeKey() {
            return 'translations/' + this.translatable_type + this.translatable_id;
        },
        visibility() {
            return this.$store.getters[this.storeKey + '/visibility'];
        },
    },
    methods: {
        toggleVisibility(column) {
            this.$store.dispatch(this.storeKey + '/toggleVisibility', column)
        },
        translationsLoad() {
            this.loading = true;
            this.$store.dispatch(this.storeKey + '/load')
                .then(() => {
                    this.loading = false;
                });
        },
    }
}