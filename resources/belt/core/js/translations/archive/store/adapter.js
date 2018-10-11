import Form from 'belt/core/js/translations/form';
import store from 'belt/core/js/translations/store';

export default {
    data() {
        return {
            translationsLoading: false,
        }
    },
    created() {
        if (!this.$store.state[this.translationStoreKey]) {
            this.$store.registerModule(this.translationStoreKey, store);
        }
        this.$store.dispatch(this.translationStoreKey + '/set', {entity_type: this.translatable_type, entity_id: this.translatable_id});
        this.translationsLoad();
    },
    computed: {
        translations() {
            return this.$store.getters[this.translationStoreKey + '/data'];
        },
        translationConfigs() {
            return this.$store.getters[this.translationStoreKey + '/config'];
        },
        translationStoreKey() {
            return 'translations/' + this.translatable_type + this.translatable_id;
        },
    },
    methods: {
        translationsLoad() {
            this.translationsLoading = true;
            this.$store.dispatch(this.translationStoreKey + '/load')
                .then(() => {
                    this.translationsLoading = false;
                });
        },
    }
}