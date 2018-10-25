import baseInput from 'belt/core/js/inputs/shared';
import storeAdapter from 'belt/core/js/translations/store/adapter';
import html from 'belt/core/js/translations/inputs/textarea/template.html';

export default {
    mixins: [baseInput, storeAdapter],
    props: ['locale'],
    data() {
        return {
            loading: false,
            eventBus: this.$parent.eventBus,
        }
    },
    created() {
        let eventKey = this.entity_type + ':' + this.entity_id + ':updating';
        Events.$on(eventKey, () => {
            this.update();
        });
    },
    computed: {
        dirty() {
            return this.translation.dirty('value');
        },
        translation() {
            return this.$store.getters[this.translationsStoreKey + '/translation']({
                locale: this.altLocale,
                translatable_column: this.column,
            });
        },
        translationsStoreKey() {
            return 'translations/' + this.entity_type + this.entity_id;
        },
    },
    mounted() {
        this.pushTranslation({locale: this.altLocale, translatable_column: this.column});
        // this.eventBus.$on('update', () => {
        //     this.update();
        // });
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