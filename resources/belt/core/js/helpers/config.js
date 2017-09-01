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
        this.loaded = false;
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
                    this.loaded = true;
                    /**
                     * @todo remove next line
                     */
                    this.data = response.data;
                    this.setData(response.data);
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                });
        });
    }

    /**
     * Set all relevant data for the form.
     */
    setData(data) {
        this.originalData = data;

        for (let field in data) {
            this[field] = data[field];
        }
    }

}

export default Config;