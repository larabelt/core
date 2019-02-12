import * as child from 'belt/core/js/helpers/child';

export default {
    created() {
        this.content = !_.isEmpty(this.initialValue) ? this.initialValue : '';
    },
    props: {
        ...child.propForm(),
        initialValue: {
            type: String
        },
    },
    watch: {
        initialValue() {
            this.storeValue();
        }
    },
    data() {
        return {
            content: '',
        }
    },
    methods: {
        updateValue() {
            this.$emit('input', String(this.content));
        },
        setContent(value) {
            this.content = value;
        },
        storeValue() {
            if (this.initialValue && !this.content) {
                this.setContent(this.initialValue);
            }
        }
    },
}