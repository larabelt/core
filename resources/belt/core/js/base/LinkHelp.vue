<template>
    <span v-if="showButton" class="pull-right">
        <a :href="url" target="_blank"><i class="fa fa-question-circle"></i></a>
    </span>
</template>

<script>
    export default {
        props: {
            docKey: {
                type: String,
            },
        },
        computed: {
            buttonClass() {
                return this.translationsVisible ? 'btn-warning' : 'btn-default';
            },
            showButton() {
                return this.url;
            },
            url() {
                return _.get(window, 'larabelt.docs.' + this.docKey);
            },
        },
    }
</script>