import store from 'belt/core/js/translations/store';

export default {
    // props: {
    //     translatable_type: {
    //         default: function () {
    //             return this.$parent.entity_type;
    //         }
    //     },
    //     translatable_id: {
    //         default: function () {
    //             return this.$parent.entity_id;
    //         }
    //     },
    // },
    data() {
        return {
            translationsLoading: false,
        }
    },
    computed: {
        altLocale() {
            let locale = _.get(window, 'larabelt.locale', []);
            return locale != this.fallbackLocale ? locale : false;
        },
        altLocales() {
            return _.differenceBy(this.locales, [{'code': this.fallbackLocale}], 'code');
        },
        canAutoTranslate() {
            return _.get(window, 'larabelt.translate.auto-translate', false);
        },
        fallbackLocale() {
            return _.get(window, 'larabelt.fallback_locale', '');
        },
        locales() {
            return _.get(window, 'larabelt.locales', []);
        },
        translatable_type() {
            return this.$parent.entity_type;
        },
        translatable_id() {
            return this.$parent.entity_id;
        },
        // translations() {
        //     return this.$store.getters[this.translationsStoreKey + '/translations'];
        // },
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
            this.translationsLoading = true;
            let translations = _.get(this.form, 'translations', []);
            if (translations.length) {
                this.$store.dispatch(this.translationsStoreKey + '/pushTranslations', translations)
                    .then(() => {
                        this.translationsLoading = false;
                    });
            } else {
                this.$store.dispatch(this.translationsStoreKey + '/load')
                    .then(() => {
                        this.translationsLoading = false;
                    });
            }
        },
        toggleTranslationsVisibility(values) {
            this.$store.dispatch(this.translationsStoreKey + '/toggleVisibility', values)
        },
    }
}