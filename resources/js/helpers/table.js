class BaseTable {

    /**
     * Create a new Form instance.
     *
     * @param {object} options
     */
    constructor(options = {}) {
        this.router = options.router;
        this.service = null;
        this.query = {
            page: 1,
            perPage: null,
            q: null,
            orderBy: null,
            sortBy: null,
        };
        this.items = {};
        this.total = null;
        this.per_page = null;
        this.current_page = 1;
        this.last_page = null;
        this.from = null;
        this.to = null;
    }

    setRouter(router) {
        this.router = router;
    }

    /**
     * GET the form object
     *
     * @param query
     * @returns {Promise}
     */
    paginate(query = {}) {
        console.log('paginator.paginate()');
        console.log(query);
        return new Promise((resolve, reject) => {
            this.service.get('', query)
                .then(response => {
                    console.log('paginator.paginate():then');
                    console.log(response.data);
                    this.items = response.data.data;
                    this.total = response.data.total;
                    this.per_page = response.data.per_page;
                    this.current_page = response.data.current_page;
                    this.last_page = response.data.last_page;
                    this.from = response.data.from;
                    this.to = response.data.to;
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error.response.data);
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
        console.log('paginator.destroy()');
        console.log(id);
        return new Promise((resolve, reject) => {
            this.service.delete(id)
                .then(response => {
                    console.log('paginator.destroy():then');
                    console.log(response.data);
                    //this.items = response.data.data;
                    this.index();
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error.response.data);
                });
        });
    }

}

export default BaseTable;