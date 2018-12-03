import LocalesStore from 'belt/core/js/locales/store/adapter';
import store from 'belt/core/js/translations/store';

export default {
    mixins: [LocalesStore],
    computed: {
        translatable_type() {
            return this.$parent.entity_type;
        },
        translatable_id() {
            return this.$parent.entity_id;
        },
        translationsStoreKey() {
            return 'translations/' + this.translatable_type + this.translatable_id;
        },
        translationsVisible() {
            return this.$store.getters[this.translationsStoreKey + '/visible'];
        },
    },
    methods: {
        bootTranslationStore() {
            if (!this.$store.state[this.translationsStoreKey]) {
                this.$store.registerModule(this.translationsStoreKey, store);
                this.$store.dispatch(this.translationsStoreKey + '/set', {entity_type: this.translatable_type, entity_id: this.translatable_id});
                this.loadTranslations();
            }
        },
        pushTranslation(values) {
            this.$store.dispatch(this.translationsStoreKey + '/pushTranslation', values)
        },
        loadTranslations() {
            let translations = _.get(this.form, 'translations', []);
            if (translations.length) {
                this.$store.dispatch(this.translationsStoreKey + '/pushTranslations', translations);
            } else {
                this.$store.dispatch(this.translationsStoreKey + '/load');
            }
        },
        toggleTranslationsVisibility() {
            this.$store.dispatch(this.translationsStoreKey + '/toggleVisibility');
        },
        setTranslationsVisibility(value) {
            this.$store.dispatch(this.translationsStoreKey + '/setVisibility', value);
        },
    }
}