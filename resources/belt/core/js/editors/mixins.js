export default {
    created() {
        this.content = this.value;
    },
    data() {
        return {
            content: '',
            watchLoaded: false,
        }
    },
    props: ['value'],
    methods: {
        updateValue(value) {
            this.$emit('input',String(this.content));
        },
        storeValue() {
            if( this.value && !this.watchLoaded ) {
                this.watchLoaded = true;
                this.content = this.value;
            }
        }
    },
    watch: {
        value() {
            this.storeValue();
        }
    }
}