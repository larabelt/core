<template>
    <select class="form-control" v-model="locale" title="select locale" @change="change()">
        <template v-for="locale in altLocales">
            <option :value="locale.code">{{ locale.label }}</option>
        </template>
    </select>
</template>
<script>
    import locales from 'belt/core/js/translations/mixins/locales';

    export default {
        mixins: [locales],
        data() {
            return {
                locale: '',
            }
        },
        mounted() {
            this.locale = this.altLocale;
        },
        computed: {
            show() {
                return !_.isEmpty(this.locales);
            },
        },
        methods: {
            change(event) {
                this.$router.push({query: {locale: this.locale}});
                window.location.reload();
            },
        },
    }
</script>