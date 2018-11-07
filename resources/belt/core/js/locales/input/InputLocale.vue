<template>
    <select class="form-control" v-model="form.locale" title="select locale" @change="change">
        <template v-for="locale in options">
            <option :value="locale.code">{{ locale.code }} - {{ locale.label }}</option>
        </template>
    </select>
</template>
<script>
    import BaseInput from 'belt/core/js/inputs/shared';
    import StoreLocale from 'belt/core/js/locales/store/adapter';

    export default {
        mixins: [BaseInput, StoreLocale],
        props: {
            useAllLocales: {
                type: Boolean,
                default: true,
            },
        },
        computed: {
            options() {
                return this.useAllLocales ? this.locales : this.altLocales;
            }
        },
        mounted() {
            if (!this.form.locale) {
                this.form.locale = this.fallbackLocale;
            }
        },
        methods: {
            change(event) {
                this.$emit('change-locale', this.form.locale);
            },
        },
    }
</script>