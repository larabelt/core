class Config {

    /**
     * Create a new Form instance.
     *
     * @param {object} options
     */
    constructor(options = {}) {
        this.service = null;
        this.query = {};
        this.data = null;
    }

    /**
     * GET the form object
     *
     * @param query
     * @returns {Promise}
     */
    load() {
        return new Promise((resolve, reject) => {
            this.service.get('', this.query)
                .then(response => {
                    this.data = response.data;
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                });
        });
    }

}

export default Config;