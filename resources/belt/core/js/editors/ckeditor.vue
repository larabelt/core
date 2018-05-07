<template>
    <ckeditor v-model="content"
              :config="config"></ckeditor>
</template>

<script>
/*
    WIll need to require this in the package.json when working on this again.  Or find a new package. "vue-ckeditor2": "^1.21.0",
*/
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