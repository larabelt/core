export default {
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
    },
    methods: {

    }
}