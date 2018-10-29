export default {
    created() {
        this.content = !_.isEmpty(this.value) ? this.value : '';
    },
    data() {
        return {
            content: '',
        }
    },
    props: {
        value: {
            type: String
        },
    },
    methods: {
        updateValue(value) {
            this.$emit('input', String(this.content));
        },
        setContent(value) {
            this.content = value;
        },
        storeValue() {
            if (this.value && !this.content) {
                //this.watchForAsync = false;
                this.setContent(this.value);
            }
        }
    },
    watch: {
        value() {
            this.storeValue();
        }
    }
}