<template>
    <div>
        <input
                type="hidden"
                :id="inputID"
                z-model="form[column]"
                v-model="content"
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
        props: {
            initialValue: {
                type: String,
            },
        },
        data() {
            let name = Math.random().toString(36).substring(7);
            return {
                content: '',
                editorID: 'trix-' + name,
                inputID: 'editor-' + name,
                name: name,
            }
        },
        created() {
            this.content = !_.isEmpty(this.initialValue) ? this.initialValue : '';
        },
        watch: {
            initialValue() {
                this.passInitialValue();
            }
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
                //this.form[this.column] = this.element.value;
                this.setContent(this.element.value);
                console.log(111, this.element.value, this.content, String(this.content));
                this.$emit('input', String(this.content));
            },
            passInitialValue() {
                if (this.initialValue && !this.content) {
                    this.setContent(this.initialValue);
                    this.editor.insertHTML(this.initialValue);
                }
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