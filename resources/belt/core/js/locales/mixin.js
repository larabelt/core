import {mapState} from 'vuex';

export default {
    created() {
        if (!this.$store.getters['locales/initialized']) {
            this.initializeLocalesStore();
        }
    },
    computed: {
        ...mapState('locales', [
            'canAutoTranslate',
            'fallbackLocale',
            'locale',
            'locales',
        ]),
        altLocale() {
            return this.locale != this.fallbackLocale ? this.locale : false;
        },
        altLocales() {
            return _.differenceBy(this.locales, [{'code': this.fallbackLocale}], 'code');
        },
    },
    methods: {
        initializeLocalesStore() {
            this.$store.dispatch('locales/setCanAutoTranslate', _.get(window, 'larabelt.translate.auto-translate', false));
            this.$store.dispatch('locales/setInitialized', true);
            this.$store.dispatch('locales/setFallbackLocale', _.get(window, 'larabelt.fallback_locale', ''));
            this.$store.dispatch('locales/setLocale', Cookies.get('locale') ? Cookies.get('locale') : '');
            this.$store.dispatch('locales/setLocales', _.get(window, 'larabelt.locales', []));
        },
        setLocale(code) {
            Cookies.set('locale', code);
            this.$store.dispatch('locales/setLocale', code);
        },
    }
}