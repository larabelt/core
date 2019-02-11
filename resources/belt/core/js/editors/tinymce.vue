<template>
    <tinymce-editor
            v-model="content"
            :init="init"
            :initial-value="initialValue"
            @onChange="handleChange"
    ></tinymce-editor>
</template>

<script>
    import TinyMCEVue from '@tinymce/tinymce-vue';
    import editorMixins from 'belt/core/js/editors/mixins';

    export default {
        mixins: [editorMixins],
        data() {
            return {
                init: {
                    height: '400px',
                    plugins: 'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste code wordcount',
                    toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code'
                }
            }
        },
        methods: {
            handleChange() {
                this.$emit('change', this.content);
                this.updateValue();
            },
        },
        components: {
            'tinymce-editor': TinyMCEVue,
        },
    }
</script>


