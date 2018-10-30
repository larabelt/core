<template>
    <div>
        <input
                type="hidden"
                :id="inputID"
                v-model="form[column]"
                :name="key"
        />
        <trix-editor
                :id="editorID"
                :input="inputID"
                @trix-change="change"
        ></trix-editor>
    </div>
</template>

<script>
    import base_input from 'belt/core/js/inputs/shared';

    Vue.config.ignoredElements = ['trix-editor'];
    Trix.config.blockAttributes.default.tagName = "p";

    export default {
        mixins: [base_input],
        props: {},
        data() {
            let key = Math.random().toString(36).substring(7);
            return {
                canOverrideEditorContent: true,
                content: '',
                editorID: 'trix-' + key,
                inputID: 'editor-' + key,
                key: key,
            }
        },
        created() {
            // set dynamic form watcher
            this.$watch('form.' + this.column, function (newValue) {
                this.overrideEditorContent(newValue);
            });
            Events.$on('allow-override-editor-content', () => {
                this.canOverrideEditorContent = true;
            });
        },
        mounted() {

        },
        computed: {
            document() {
                return _.get(this.editor, 'getDocument', {});
            },
            element() {
                return document.querySelector("#trix-" + this.key, {});
            },
            editor() {
                return _.get(this.element, 'editor');
            },
        },
        methods: {
            change() {
                this.form[this.column] = this.element.value;
                this.setContent(this.element.value);
                this.$emit('input', String(this.content));
            },
            overrideEditorContent(value) {
                if (value && this.canOverrideEditorContent) {
                    this.canOverrideEditorContent = false;
                    this.setContent(value);
                    this.setEditorContent(value);
                }
            },
            setEditorContent(value) {
                this.element.value = value;
            },
            setContent(value) {
                this.content = value;
            },
            updateValue(value) {
                this.$emit('input', String(this.content));
            },
        },
    }
</script>