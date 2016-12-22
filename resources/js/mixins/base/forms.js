export default {
    data() {
        return {
            url: '',
            needle: '',
            saving: false,
            saved: false,
            id: false,
            item: {},
            items: {},
            filtered: {},
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
        getPaginatorData(response) {
            return {
                'total': response.data.total,
                'per_page': response.data.per_page,
                'current_page': response.data.current_page,
                'last_page': response.data.last_page,
                'from': response.data.from,
                'to': response.data.to,
                'meta': response.data.meta,
            }
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