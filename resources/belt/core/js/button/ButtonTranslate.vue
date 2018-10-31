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
                //this.toggleTranslationsVisibility();
                this.toggle();
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
                this.$emit('change-locale');
                this.setLocale(code);
            },
            toggle() {

                let visible = !this.translationsVisible;

                //this.toggleTranslationsVisibility();

                this.setTranslationsVisibility(visible);

                //History.set('translations', 'visible', this.translationsVisible);
                History.set('translations', 'visible', visible);
                let paramsStoreKey = 'params/' + this.translatable_type + this.translatable_id;
                let params = this.$store.getters[paramsStoreKey + '/data'];
                _.each(params, (param) => {
                    let paramTranslationStoreKey = 'translations/params' + param.id;
                    if (this.$store.state[paramTranslationStoreKey]) {
                        //this.$store.dispatch(paramTranslationStoreKey + '/toggleVisibility');
                        this.$store.dispatch(paramTranslationStoreKey + '/setVisibility', visible);
                    }
                });
            },
        },
        components: {
            FilterLocale,
        }
    }
</script>