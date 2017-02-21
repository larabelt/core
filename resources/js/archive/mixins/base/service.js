export default {
    methods: {
        submit(event) {
            event.preventDefault();
            this.status = 'saving';
            if (this.item.id) {
                return this.put(this.item);
            }
            return this.post(this.item);
        },
        pushRouteQueryToParams(namespace) {
            _(this.$route.query).forEach((value, key) => {
                this[namespace].params[key] = value;
            });
        },
    }
};