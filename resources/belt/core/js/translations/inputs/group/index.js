import baseInput from 'belt/core/js/inputs/shared';
import storeAdapter from 'belt/core/js/translations/store/adapter';
import translationTextInput from 'belt/core/js/translations/inputs/text';
import html from 'belt/core/js/translations/inputs/group/template.html';

export default {
    mixins: [baseInput, storeAdapter],
    data() {
        return {
            eventBus: new Vue(),
        }
    },
    created() {
        let eventKey = this.entity_type + ':' + this.entity_id + ':updating';
        Events.$on(eventKey, () => {
            this.update();
        });
    },
    mounted() {
        this.translationsLoad();
    },
    computed: {
        visible() {
            return _.get(this.translationsVisibility, this.column, true);
        },
        translationsByColumn() {
            let translations = [];

            //sort by locale... show empty, late to STORE vs UPDATE

            _.forOwn(this.locales, (name, locale) => {
                let translation = _.find(this.translations, {
                    locale: locale,
                    key: this.column,
                });
                translations.push(translation ? translation : {locale: locale, key: this.column});
            });

            return translations;
        },
    },
    methods: {
        update() {
            this.eventBus.$emit('update');
            setTimeout(() => {
                this.load();
            }, 500);
        },
    },
    components: {
        translationTextInput,
    },
    template: html
}