export default {
    data() {
        return {
            mode: 'default',
        }
    },
    methods: {
        isMode(mode) {
            return this.mode == mode;
        },
        setMode(mode) {
            this.mode = mode;
        },
    }
};