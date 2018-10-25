import baseInput from 'belt/core/js/inputs/shared';
import storeAdapter from 'belt/core/js/translations/store/adapter';
import html from 'belt/core/js/translations/input/text/template.html';

export default {
    mixins: [baseInput, storeAdapter],
    props: ['locale'],
    data() {
        return {
            checked: false,
            loading: false,
            eventBus: this.$parent.eventBus,
        }
    },
    computed: {
        dirty() {
            return this.translation.dirty('value');
        },
        translation() {
            return this.$store.getters[this.translationsStoreKey + '/translation']({
                locale: this.locale,
                translatable_column: this.column,
            });
        },
        translationsStoreKey() {
            return 'translations/' + this.entity_type + this.entity_id;
        },
    },
    mounted() {
        this.pushTranslation({locale: this.locale, translatable_column: this.column});
        this.eventBus.$on('fetch-auto-translation', () => {
            if (this.checked) {
                console.log('_auto_translate');
                this.translation._auto_translate = true;
                this.submit();
            }
        });
        this.eventBus.$on('toggle-checked', (checked) => {
            this.checked = checked;
        });
        this.eventBus.$on('update', () => {
            this.update();
        });
    },
    methods: {
        update() {
            if (this.dirty && (this.translation.id || this.translation.value)) {
                this.translation.submit();
            }
        },
        submit() {
            this.loading = true;
            this.translation.submit()
                .then(() => {
                    this.loading = false;
                });
        }
    },
    template: html,
}