<template>
    <textarea class="form-control"
              cols="30"
              rows="10"
              v-model="content"
              v-on:input="updateValue"></textarea>
</template>

<script>
    import editorMixins from 'belt/core/js/editors/mixins';

    export default {
        mixins: [editorMixins]
    }
</script>