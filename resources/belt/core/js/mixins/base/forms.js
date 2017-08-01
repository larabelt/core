export default {
    data() {
        return {
            attached: [],
            detached: [],
            errors: {},
            item: {},
            items: {},
            needle: '',
            paginator: {},
            saved: false,
            saving: false,
            status: false,
            query: {},
            url: '',
        }
    },
    methods: {
        submit(event) {
            event.preventDefault();
            this.saving = true;
            this.saved = false;

            if (this.item.id) {
                return this.update(this.item);
            }
            return this.store(this.item);
        },
        setPaginator(response) {
            return {
                'total': response.data.total,
                'per_page': response.data.per_page,
                'current_page': response.data.current_page,
                'last_page': response.data.last_page,
                'from': response.data.from,
                'to': response.data.to,
            }
        },
        getUrlQuery() {
            let params = {};
            _(this.$route.query).forEach((value, key) => {
                params[key] = value;
            });
            return params;
        },
        getParams() {
            return this.getUrlQuery();
        },
    }
};