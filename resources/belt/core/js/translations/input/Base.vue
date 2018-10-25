<template>

</template>

<script>
    import BaseInput from 'belt/core/js/inputs/shared';
    import StoreAdapter from 'belt/core/js/translations/store/adapter';
    import TranslationInputGroup from 'belt/core/js/translations/input/group';

    export default {
        mixins: [BaseInput, StoreAdapter],
        data() {
            return {
                loading: false,
            }
        },
        computed: {
            dirty() {
                return this.translation.dirty('value');
            },
            eventBus() {
                return this.$parent.eventBus;
            },
            translation() {
                return this.$store.getters[this.storeKey + '/translation']({
                    locale: this.altLocale,
                    translatable_column: this.column,
                });
            },
            storeKey() {
                return 'translations/' + this.entity_type + this.entity_id;
            },
        },
        mounted() {
            this.pushTranslation({locale: this.altLocale, translatable_column: this.column});
            this.eventBus.$on('update', this.submitIfDirty);
            this.eventBus.$on('fetch-auto-translation', this.fetchAutoTranslation);
        },
        methods: {
            fetchAutoTranslation() {
                this.translation._auto_translate = true;
                this.submit();
            },
            submitIfDirty() {
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
            },
        },
        components: {
            TranslationInputGroup,
        },
    }
</script>