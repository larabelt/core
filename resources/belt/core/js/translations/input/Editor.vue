<template>
    <belt-editor :initialValue="translation.value" @input="emitEvent"></belt-editor>
</template>

<script>
    import BaseTranslationInput from 'belt/core/js/translations/input/Base';

    export default {
        mixins: [BaseTranslationInput],
        methods: {
            emitEvent(payload) {
                this.translation.value = payload;
            }
        },
    }
</script>