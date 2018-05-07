<template>
    <codemirror v-model="content"
                :options="cmOptions"
                v-on:input="updateValue"></codemirror>
</template>

<script>
    import { codemirror } from 'vue-codemirror'
    import 'codemirror/lib/codemirror.css'
    import editorMixins from 'belt/core/js/editors/mixins';

    export default {
        components: { codemirror },
        data() {
            return {
                cmOptions: {
                    tabSize: 4,
                    mode: 'text/javascript',
                    theme: 'base16-dark',
                    lineNumbers: true,
                    line: true,
                }
            }
        },
        mixins: [editorMixins]
    }
</script>