<template>
    <a
            v-if="form.id"
            class="btn btn-sm btn-default"
            target="_blank"
            :href="_href"
    >preview</a>
</template>

<script>
    import shared from 'belt/core/js/button/shared';
    import LocalesStore from 'belt/core/js/locales/store/adapter';
    import TranslatableStore from 'belt/core/js/translations/store/adapter';

    export default {
        mixins: [shared, LocalesStore, TranslatableStore],
        props: {
            href: {
                type: String,
                default: function () {
                    return '/' + this.form.morph_class + '/' + this.form.id;
                }
            },
        },
        computed: {
            _href() {
                let href = this.href;
                if (this.translationsVisible && this.altLocale) {
                    href = href + '?locale=' + this.altLocale;
                }
                return href;
            },
            translatable_type() {
                return this.form.morph_class;
            },
            translatable_id() {
                return this.form.id;
            },
        }
    }
</script>