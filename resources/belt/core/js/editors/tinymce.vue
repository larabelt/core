<template>
    <vue-mce v-model="content"
             ref="editor"
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
        methods: {
            storeValue() {
                if( this.value  && !this.watchLoaded ) {
                    this.watchLoaded = true;

                    /*
                        For some reason both of these in combo work but sometimes don't load when only 1 of them is present.
                        Could be on our end or in the plugin
                     */
                    this.$refs['editor'].setContent(this.value);
                    this.content = this.value;
                }
            }
        },
        mixins: [editorMixins]
    }
</script>


