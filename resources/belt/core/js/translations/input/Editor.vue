<template>
    <belt-editor v-model="translation.value"></belt-editor>
</template>

<script>
    import BaseTranslationInput from 'belt/core/js/translations/input/Base';

    export default {
        mixins: [BaseTranslationInput],
    }
</script>