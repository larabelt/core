class BaseService {

    /**
     * Create a new Service instance.
     *
     * @param {object} options
     */
    constructor(options = {}) {
        this.baseUrl = options.baseUrl;
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

    post(data = {}) {
        console.log('service.post()');
        console.log(data);
        return this.submit('post', this.url(), data);
    }

    put(id, data = {}) {
        return this.submit('put', this.url(id), data);
    }

    delete(id) {
        return this.submit('delete', this.url(id));
    }
}

export default BaseService;