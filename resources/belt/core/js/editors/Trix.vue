<template>
    <div>
        <input
                type="hidden"
                :id="inputID"
                v-model="form[column]"
                :name="name"
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
            let name = Math.random().toString(36).substring(7);
            return {
                canOverrideEditorContent: true,
                content: '',
                editorID: 'trix-' + name,
                inputID: 'editor-' + name,
                name: name,
            }
        },
        created() {
            // set dynamic form watcher
            this.$watch('form.' + this.column, function (newValue) {
                this.overrideEditorContent(newValue);
            });
            Events.$on('allow-override-editor-content', () => {
                console.log(111, this.canOverrideEditorContent);
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
                return document.querySelector("#trix-" + this.name, {});
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
                console.log(111, this.editorID, 'override');
                if (value && this.canOverrideEditorContent) {
                    this.canOverrideEditorContent = false;
                    //if (!this.content) {
                        console.log(222, this.editorID, 'override');
                        this.setContent(value);
                        this.setEditorContent(value);
                    //}
                }
            },
            setEditorContent(value) {
                //this.editor.loadHTML("");
                this.element.value = '';
                //this.element.value = value;
                this.editor.insertHTML(value);
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