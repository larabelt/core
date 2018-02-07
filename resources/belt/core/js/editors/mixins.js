export default {
    created() {
        this.content = this.value;
    },
    data() {
        return {
            content: ''
        }
    },
    props: ['value'],
    methods: {
        updateValue(value) {
            this.$emit('input',String(this.content));
        }
    },
    watch: {
        value() {
            if( this.value ) {
                this.content = this.value;
            }
        }
    }
}