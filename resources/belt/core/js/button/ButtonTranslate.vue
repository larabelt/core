<template>
    <div v-if="showButton" class="form-inline">
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
    import FilterLocale from 'belt/core/js/locales/filter/FilterLocale';
    import TranslatableStore from 'belt/core/js/translations/store/adapter';

    export default {
        mixins: [shared, TranslatableStore],
        mounted() {
            if (!this.translationsVisible && History.get('translations', 'visible')) {
                this.toggle();
            }
        },
        computed: {
            buttonClass() {
                return this.translationsVisible ? 'btn-warning' : 'btn-default';
            },
            hasTranslatableAttributes() {

                if (!_.isEmpty(_.get(this.form, 'config.translatable', []))) {
                    return true;
                }

                let paramsConfig = _.get(this.form, 'config.params', {});
                for (let key in paramsConfig) {
                    let paramConfig = paramsConfig[key];
                    if (_.get(paramConfig, 'translatable')) {
                        return true;
                    }
                }

                return false;
            },
            showButton() {
                return this.hasLocales && this.hasTranslatableAttributes;
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
                this.setTranslationsVisibility(visible);
                History.set('translations', 'visible', visible);
                let paramsStoreKey = 'params/' + this.translatable_type + this.translatable_id;
                let params = this.$store.getters[paramsStoreKey + '/data'];
                _.each(params, (param) => {
                    let paramTranslationStoreKey = 'translations/params' + param.id;
                    if (this.$store.state[paramTranslationStoreKey]) {
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