<template>
    <textarea class="form-control" rows="10" v-if="translation" v-model="translation.value"></textarea>
</template>

<script>
    import BaseTranslationInput from 'belt/core/js/translations/input/Base';

    export default {
        mixins: [BaseTranslationInput],
    }
</script>