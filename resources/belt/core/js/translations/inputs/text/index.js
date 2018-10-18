import Form from 'belt/core/js/translations/form';
import baseInput from 'belt/core/js/inputs/shared';
import storeAdapter from 'belt/core/js/translations/store/adapter';
import html from 'belt/core/js/translations/inputs/text/template.html';

export default {
    mixins: [baseInput, storeAdapter],
    props: ['locale'],
    data() {
        return {
            checked: false,
            eventBus: this.$parent.eventBus,
        }
    },
    computed: {
        // column() {
        //     return this.$parent.column;
        // },
        dirty() {
            return this.translation.dirty('value');
        },
        // entity_type() {
        //     return this.$parent.entity_type;
        // },
        // entity_id() {
        //     return this.$parent.entity_id;
        // },
        translation() {
            return this.$store.getters[this.translationsStoreKey + '/translation']({
                locale: this.locale,
                column: this.column,
            });
        },
        translationsStoreKey() {
            return 'translations/' + this.entity_type + this.entity_id;
        },
    },
    mounted() {
        this.pushTranslation({locale: this.locale, key: this.column});
        this.eventBus.$on('update', () => {
            this.update();
        });
    },
    updated() {
        //this.pushTranslation({locale: this.locale, key: this.column});
    },
    methods: {
        update() {
            if (this.dirty && (this.translation.id || this.translation.value)) {
                this.translation.submit();
            }
        },
    },
    template: html,
}