import template from 'belt/core/js/base/locale-dropdown/template.html';

export default {
    data() {
        return {
            locale: _.get(window, 'larabelt.locale'),
        }
    },
    computed: {
        locales() {
            return _.get(window, 'larabelt.locales', []);
        },
        show() {
            return !_.isEmpty(this.locales);
        },
    },
    methods: {
        change(event) {
            this.$router.push({query: {locale: this.locale}});
            window.location.reload();
        },
    },
    template: template
}