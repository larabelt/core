export default {
    computed: {
        altLocale() {
            //let locale = _.get(window, 'larabelt.locale', []);
            let locale = Cookies.get('locale');
            return locale != this.fallbackLocale ? locale : false;
        },
        altLocales() {
            return _.differenceBy(this.locales, [{'code': this.fallbackLocale}], 'code');
        },
        locale() {
            return this.altLocale ? this.altLocale : this.fallbackLocale;
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
    methods: {}
}