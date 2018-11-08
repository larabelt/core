<template>
    <select class="form-control" v-model="activeLocale" title="select locale" @change="change">
        <template v-for="locale in altLocales">
            <option :value="locale.code">{{ locale.code }} - {{ locale.label }}</option>
        </template>
    </select>
</template>
<script>
    import locales from 'belt/core/js/locales/store/adapter';

    export default {
        mixins: [locales],
        data() {
            return {
                activeLocale: '',
            }
        },
        mounted() {
            this.activeLocale = this.locale;
        },
        methods: {
            change(event) {
                this.$emit('change-locale', this.activeLocale);
            },
        },
    }
</script>