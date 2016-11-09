export default {
    data() {
        return {
            saving: false,
            saved: false,
            id: false,
            item: {},
            items: {},
            errors: {}
        }
    },
    methods: {
        submit(event) {
            event.preventDefault();
            this.saving = true;
            this.saved = false;

            if (this.id) {
                return this.put(this.item);
            }
            return this.post(this.item);
        },
        getUrlParams() {
            let params = {};
            _(this.$route.query).forEach((value, key) => {
                params[key] = value;
            });
            return params;
        },
        getParams() {
            return this.getUrlParams();
        },
    }
};