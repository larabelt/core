<template>
    <a
            v-if="form.id"
            class="btn btn-sm btn-default"
            target="_blank"
            :href="href"
    >preview</a>
</template>

<script>
    import shared from 'belt/core/js/button/shared';
    import LocalesStore from 'belt/core/js/locales/store/adapter';
    import TranslatableStore from 'belt/core/js/translations/store/adapter';

    export default {
        mixins: [shared, LocalesStore, TranslatableStore],
        props: {
            initial_href: {
                type: String,
            },
        },
        computed: {
            href() {
                return this.initial_href ? this.initial_href : this.auto_href;
            },
            auto_href() {
                let href = '/' + this.form.morph_class + '/' + this.form.id;
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