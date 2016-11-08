export default {
    data() {
        return {
            page: {},
            saving: false,
            saved: false,
            errors: {}
        }
    },
    methods: {
        submit(event) {
            event.preventDefault();
            this.saving = true;
            this.saved = false;
            if (this.$parent.id) {
                return this.put(this.page);
            }
            return this.post(this.page);
        }
    }
};