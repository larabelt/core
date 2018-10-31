<template>
    <div class="form-inline">
        <button
                class="btn btn-sm"
                :class="buttonClass"
                @click.prevent="toggle"
        >
            translate
        </button>
        <filter-locale v-if="translationsVisible" @change-locale="changeLocale"></filter-locale>
    </div>
</template>

<script>
    import shared from 'belt/core/js/button/shared';
    import FilterLocale from 'belt/core/js/filters/FilterLocale';
    import translatable from 'belt/core/js/translations/store/adapter';

    export default {
        mixins: [shared, translatable],
        mounted() {
            if (!this.translationsVisible && History.get('translations', 'visible')) {
                this.toggleTranslationsVisibility();
            }
        },
        computed: {
            buttonClass() {
                return this.translationsVisible ? 'btn-warning' : 'btn-default';
            },
            translatable_type() {
                return this.form.morph_class;
            },
            translatable_id() {
                return this.form.id;
            },
        },
        methods: {
            changeLocale(code) {
                console.log('change-locale', code);
                Cookies.set('locale', code);
                this.$emit('change-locale');
            },
            toggle() {
                this.toggleTranslationsVisibility();
                History.set('translations', 'visible', this.translationsVisible);
                let paramsStoreKey = 'params/' + this.translatable_type + this.translatable_id;
                let params = this.$store.getters[paramsStoreKey + '/data'];
                _.each(params, (param) => {
                    let paramTranslationStoreKey = 'translations/params' + param.id;
                    if (this.$store.state[paramTranslationStoreKey]) {
                        this.$store.dispatch(paramTranslationStoreKey + '/toggleVisibility');
                    }
                });
            },
        },
        components: {
            FilterLocale,
        }
    }
</script>