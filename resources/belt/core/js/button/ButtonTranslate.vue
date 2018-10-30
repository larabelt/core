<template>
    <button class="btn btn-default btn-sm" @click.prevent="toggle">
        translate
    </button>
</template>

<script>
    import shared from 'belt/core/js/button/shared';
    import translatable from 'belt/core/js/translations/store/adapter';

    export default {
        mixins: [shared, translatable],
        computed: {
            translatable_type() {
                return this.form.morph_class;
            },
            translatable_id() {
                return this.form.id;
            },
        },
        methods: {
            toggle() {
                this.toggleTranslationsVisibility();
                let paramsStoreKey = 'params/' + this.translatable_type + this.translatable_id;
                let params = this.$store.getters[paramsStoreKey + '/data'];
                _.each(params, (param) => {
                    let paramTranslationStoreKey = 'translations/params' + param.id;
                    this.$store.dispatch(paramTranslationStoreKey + '/toggleVisibility');
                });
            },
        },
    }
</script>