<template>
    <belt-editor v-if="translation" v-model="translation[column]" :form="translation" @input="emitEvent()" :key="key"></belt-editor>
</template>

<script>
    import BaseTranslationInput from 'belt/core/js/translations/input/Base';

    export default {
        mixins: [BaseTranslationInput],
        methods: {
            emitEvent(payload) {
                //this.translation.value = payload;
            }
        },
    }
</script>