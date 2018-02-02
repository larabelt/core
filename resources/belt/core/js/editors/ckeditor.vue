<template>
    <ckeditor v-model="content"
              :config="config"></ckeditor>
</template>

<script>
    import ckeditorSource from 'ckeditor';
    import ckeditorVue from 'vue-ckeditor2';
    import editorMixins from 'belt/core/js/editors/mixins';

    export default {
        created() {
            if (typeof CKEDITOR === 'undefined') {
                global.CKEDITOR = ckeditorSource;
            }
        },
        data () {
            return {
                config: {
                    toolbar: [
                        [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript' ]
                    ],
                    height: 300
                }
            }
        },

        components: { ckeditor: ckeditorVue },
        mixins: [editorMixins]
    }
</script>