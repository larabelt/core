<template>
    <input type="text" class="form-control" v-if="translation" v-model="translation.value"/>
</template>

<script>
    import BaseTranslationInput from 'belt/core/js/translations/input/Base';

    export default {
        mixins: [BaseTranslationInput],
    }
</script>