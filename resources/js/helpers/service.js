class BaseService {

    /**
     * Create a new Service instance.
     *
     * @param {object} options
     */
    constructor(options = {}) {
        this.baseUrl = '';
    }

    /**
     * Build the url
     *
     * @param path
     * @param query
     *
     * @returns {string}
     */
    url(path = '', query = {}) {

        let url = this.baseUrl + path;

        return url;
    }

    /**
     * Submit the request.
     *
     * @param {string} requestType
     * @param {string} url
     * @param {object} data
     */
    submit(requestType, url, data = {}) {
        return new Promise((resolve, reject) => {
            axios[requestType](url, data)
                .then(response => {
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                });
        });
    }

    get(id) {
        return this.submit('get', this.url(id));
    }

    store(data = {}) {
        console.log('service.store()');
        console.log(data);
        return this.submit('post', this.url(), data);
    }

    update(id, data = {}) {
        return this.submit('put', this.url(id), data);
    }

    paginate(query) {
        this.query = _.merge(this.query, query);
        let url = this.url + '?' + $.param(this.query);
        axios.get(url).then(function (response) {
            this.items = response.data.data;
            this.paginator = this.setPaginator(response);
        }, function (response) {
            console.log('error');
        });
    }

    destroy(id) {
        axios.delete(this.url + id).then(function (response) {
            if (response.status == 204) {
                this.paginate();
            }
        });
    }
}

export default BaseService;