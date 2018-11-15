<template>

</template>

<script>
    import BaseInput from 'belt/core/js/inputs/shared';
    import StoreAdapter from 'belt/core/js/translations/store/adapter';
    import TranslationInputGroup from 'belt/core/js/translations/input/Group';

    export default {
        mixins: [BaseInput, StoreAdapter],
        data() {
            let key = Math.random().toString(36).substring(7);
            return {
                key: key,
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
        beforeMount() {
            this.pushTranslation({locale: this.altLocale, translatable_column: this.column});
        },
        mounted() {
            this.eventBus.$on('update', this.submitIfDirty);
            this.eventBus.$on('fetch-auto-translation', this.fetchAutoTranslation);
        },
        methods: {
            fetchAutoTranslation() {
                //Events.$emit('allow-override-editor-content');
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
                        this.key = Math.random().toString(36).substring(7);
                        this.eventBus.$emit('updated');
                    });
            },
        },
        components: {
            TranslationInputGroup,
        },
    }
</script>