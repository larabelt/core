import Service from 'belt/core/js/helpers/service';

class BaseTable {

    /**
     * Create a new Form instance.
     *
     * @param {object} options
     */
    constructor(options = {}) {

        this.router = options.router;
        this.morphable_type = options.morphable_type;
        this.morphable_id = options.morphable_id;
        this.service = null;
        this.loading = false;

        // paginator
        this.items = [];
        this.total = null;
        this.per_page = null;
        this.current_page = 1;
        this.last_page = null;
        this.from = null;
        this.to = null;

        this.query = {
            page: 1,
            perPage: null,
            q: null,
            orderBy: null
        };

        this.name = '';

        if (options.query) {
            this.updateQuery(options.query);
        }

        if (options.baseUrl) {
            this.service = new Service({baseUrl: options.baseUrl});
        }
    }

    /**
     * update table query
     *
     * @param query
     */
    updateQuery(query) {
        for (let field in query) {
            this.query[field] = query[field];
        }
    }

    /**
     * update table query from History
     */
    updateQueryFromHistory() {
        if (this.name) {
            let query = History.get(this.name, 'table.query', {});
            this.updateQuery(query);
        }
    }

    /**
     * update table from router (ie, the browser url)
     */
    updateQueryFromRouter() {
        if (this.router && this.router.currentRoute) {
            let query = {};
            _(this.router.currentRoute.query).forEach((value, key) => {
                query[key] = value;
            });
            this.updateQuery(query);
        }
    }

    /**
     * update router from table query
     */
    pushQueryToHistory() {
        if (this.name) {
            //History.set(this.table.name, 'table.query.page', 1);
            //History.set(this.table.name, 'table.query.q', this.table.query.q);
            History.set(this.name, 'table.query', this.query);
        }
    }

    /**
     * update router from table query
     */
    pushQueryToRouter() {
        if (this.router) {
            this.router.push({query: this.getQuery()});
        }
    }

    /**
     * get table query
     */
    getQuery(key = '') {

        if (key) {
            return this.query[key] ? this.query[key] : null;
        }

        let query = {};

        for (let field in this.query) {
            if (_.has(this.query, field)) {
                query[field] = this.query[field];
            }
        }

        return query;
    }

    /**
     * GET the form object
     *
     * @param query
     * @returns {Promise}
     */
    index(options = {}) {
        this.loading = true;
        return new Promise((resolve, reject) => {
            this.service.get('', this.getQuery())
                .then(response => {
                    this.loading = false;
                    this.total = response.data.total;
                    this.per_page = response.data.per_page;
                    this.current_page = response.data.current_page;
                    this.last_page = response.data.last_page;
                    this.from = response.data.from;
                    this.to = response.data.to;

                    if( options.append ) {
                        _.each(response.data.data, item => {
                            this.items.push(item);
                        });
                    } else {
                        this.items = response.data.data;
                    }

                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                });
        });
    }

    /**
     * DELETE the paginator item
     *
     * @param id
     * @returns {Promise}
     */
    destroy(id) {
        return new Promise((resolve, reject) => {
            this.service.delete(id)
                .then(response => {
                    this.index();
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error.response.data);
                });
        });
    }

    /**
     * empty table
     */
    empty() {
        this.items = {};
        this.total = null;
        this.current_page = 1;
        this.from = null;
        this.to = null;
    }

}

export default BaseTable;