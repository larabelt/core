import Form from 'belt/core/js/translations/form';
import baseInput from 'belt/core/js/inputs/shared';
import storeAdapter from 'belt/core/js/translations/store/adapter';
import translationTextInput from 'belt/core/js/translations/input/text';
import html from 'belt/core/js/translations/input/group/template.html';

export default {
    mixins: [baseInput, storeAdapter],
    data() {
        return {
            checked: false,
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
            return _.get(this.translationsVisibility, this.column, false);
        },
        translations() {
            let translations = this.$store.getters[this.translationsStoreKey + '/translations']({translatable_column: this.column});
            return _.sortBy(translations, ['locale']);
        },
    },
    methods: {
        fetchAutoTranslation() {
            this.eventBus.$emit('fetch-auto-translation');
        },
        toggleChecked() {
            this.checked = !this.checked;
            this.eventBus.$emit('toggle-checked', this.checked);
        },
        update() {
            this.eventBus.$emit('update');
            // setTimeout(() => {
            //     this.load();
            // }, 500);
        },
    },
    components: {
        translationTextInput,
    },
    template: html
}