<template>
    <vue-mce v-model="content"
             :config="config"
             v-on:input="updateValue"></vue-mce>
</template>

<script>
    import { component } from 'vue-mce';
    import editorMixins from 'belt/core/js/editors/mixins';

    export default {
        components: { 'vue-mce': component },
        data() {
            return {
                config: {
                    plugins: 'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table contextmenu paste code',
                    toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code'
                }
            }
        },
        mixins: [editorMixins]
    }
</script>


