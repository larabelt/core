import Form from 'belt/core/js/translations/form';
import store from 'belt/core/js/translations/store';

export default {
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
            translationsLoading: false,
        }
    },
    created() {
        if (!this.$store.state[this.translationsStoreKey]) {
            this.$store.registerModule(this.translationsStoreKey, store);
        }
        this.$store.dispatch(this.translationsStoreKey + '/set', {entity_type: this.translatable_type, entity_id: this.translatable_id});
    },
    computed: {
        locales() {
            return _.get(window, 'larabelt.translate.locales', {});
        },
        translations() {
            return this.$store.getters[this.translationsStoreKey + '/data'];
        },
        translationsConfig() {
            return this.$store.getters[this.translationsStoreKey + '/config'];
        },
        translationsStoreKey() {
            return 'translations/' + this.translatable_type + this.translatable_id;
        },
        translationsVisibility() {
            return this.$store.getters[this.translationsStoreKey + '/visibility'];
        },
    },
    methods: {
        toggleTranslationsVisibility(column) {
            this.$store.dispatch(this.translationsStoreKey + '/toggleVisibility', column)
        },
        translationsLoad() {
            this.translationsLoading = true;
            this.$store.dispatch(this.translationsStoreKey + '/load')
                .then(() => {
                    this.translationsLoading = false;
                });
        },
    }
}