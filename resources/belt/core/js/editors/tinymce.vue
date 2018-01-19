<template>
    <vue-mce v-model="content"
             v-on:input="updateValue"></vue-mce>
</template>

<script>
    import { component } from 'vue-mce';
    import editorMixins from 'belt/core/js/editors/mixins';

    export default {
        components: { 'vue-mce': component },
        mixins: [editorMixins]
    }
</script>