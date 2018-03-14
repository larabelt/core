export default {
    created() {
        this.content = !_.isEmpty(this.value) ? this.value : '';
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