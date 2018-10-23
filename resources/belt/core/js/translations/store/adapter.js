import Form from 'belt/core/js/translations/form';
import store from 'belt/core/js/translations/store';
import {mapMultiRowFields} from 'vuex-map-fields';

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
            this.$store.dispatch(this.translationsStoreKey + '/set', {entity_type: this.translatable_type, entity_id: this.translatable_id});
        }
    },
    computed: {
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
        translations() {
            return this.$store.getters[this.translationsStoreKey + '/translations'];
        },
        translationsStoreKey() {
            return 'translations/' + this.translatable_type + this.translatable_id;
        },
        translationsVisibility() {
            return this.$store.getters[this.translationsStoreKey + '/visibility'];
        },
    },
    methods: {
        pushTranslation(values) {
            this.$store.dispatch(this.translationsStoreKey + '/pushTranslation', values)
        },
        toggleTranslationsVisibility(column) {
            this.$store.dispatch(this.translationsStoreKey + '/toggleVisibility', column)
        },
        translationsLoad() {
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
    }
}