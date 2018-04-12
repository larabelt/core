export default {
    created() {
        this.content = !_.isEmpty(this.value) ? this.value : '';
        if( !this.async ) {
            this.watchForAsync = false;
        }
    },
    data() {
        return {
            content: '',
            watchForAsync: true,
        }
    },
    props: {
        value : {
            type: String
        },
        async: {
            default: true
        }
    },
    methods: {
        updateValue(value) {
            this.$emit('input',String(this.content));
        },
        setContent(value) {
            this.content = value;
        },
        storeValue() {
            if( this.value && this.watchForAsync ) {
                this.watchForAsync = false;
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