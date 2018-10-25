import Errors from 'belt/core/js/helpers/errors';

class BaseForm {

    /**
     * Create a new Form instance.
     *
     * @param {object} options
     */
    constructor(options = {}) {
        this.router = options.router;
        this.entity_type = options.entity_type;
        this.entity_id = options.entity_id;
        this.hasFile = options.hasFile;
        this.errors = new Errors();
        this.saving = null;
        this.service = null;
        this.routeEditName = null;
    }

    /**
     * Set all relevant data for the form.
     */
    setData(data) {
        this.originalData = data;

        for (let field in data) {
            Vue.set(this, field, data[field]);
        }
    }

    /**
     * Merge all relevant data for the form.
     */
    mergeData(data) {
        for (let field in data) {
            Vue.set(this.originalData, field, data[field]);
            Vue.set(this, field, data[field]);
        }
    }

    /**
     * Fetch all relevant data for the form.
     */
    data() {

        if (this.hasFile) {
            return this.formData();
        }

        let data = {};

        for (let property in this.originalData) {
            data[property] = this[property];
        }

        return data;
    }

    /**
     * Fetch all relevant data for the form.
     */
    formData() {
        let formData = new FormData();

        for (let property in this.originalData) {
            if (this[property]) {
                formData.append(property, this[property]);
            } else {
                formData.append(property, '');
            }
        }

        return formData;
    }

    /**
     * Determine if value has changed
     *
     * @param key
     * @returns {boolean}
     */
    dirty(key) {

        if (!key) {
            for (let property in this.originalData) {
                if (this[property] != this.originalData[property]) {
                    return true;
                }
            }
            return false;
        }

        let original = this.originalData[key];
        let current = this[key];

        return original != current;
    }

    /**
     * Reset the form fields.
     */
    reset() {
        for (let field in this.originalData) {
            this[field] = '';
        }

        this.errors.clear();
    }

    /**
     * GET the form object
     *
     * @param id
     * @returns {Promise}
     */
    show(id) {
        return new Promise((resolve, reject) => {
            this.service.get(id)
                .then(response => {
                    this.setData(response.data);
                    resolve(response.data);
                })
                .catch(error => {
                    if (error.response) {
                        reject(error.response);
                    }
                });
        });
    }

    /**
     * PUT the form object
     *
     * @param {integer} id
     */
    update(id) {
        return new Promise((resolve, reject) => {
            this.saving = true;
            this.service.put(id, this.data())
                .then(response => {
                    this.saving = null;
                    //this.setData(response.data);
                    this.mergeData(response.data);
                    resolve(response.data);
                })
                .catch(error => {
                    this.saving = null;
                    if (error.response) {
                        this.onFail(error.response);
                        reject(error.response);
                    }
                });
        });
    }

    /**
     * POST the form object
     */
    store() {
        return new Promise((resolve, reject) => {
            this.saving = true;
            this.service.post(this.data())
                .then(response => {
                    if (this.router && this.routeEditName) {
                        this.router.push({name: this.routeEditName, params: {id: response.data.id}})
                    }
                    this.onSuccess(response.data);
                    this.saving = null;
                    this.setData(response.data);
                    resolve(response.data);
                })
                .catch(error => {
                    if (error.response) {
                        this.onFail(error.response);
                        reject(error.response);
                    }
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
                    resolve(response.data);
                })
                .catch(error => {
                    if (error.response) {
                        reject(error.response);
                    }
                });
        });
    }

    /**
     * Submit the form.
     */
    submit() {
        if (this.id) {
            return this.update(this.id);
        } else {
            return this.store();
        }
    }

    /**
     * Get error value
     *
     * @param field
     * @returns {*}
     */
    error(field) {
        return this.errors.get(field);
    }

    /**
     * Handle a successful form submission.
     *
     * @param {object} data
     */
    onSuccess(data) {
        this.saving = null;
        this.errors.clear();
        this.setData(data);
    }

    /**
     * Handle a failed form submission.
     *
     * @param {object} errors
     */
    onFail(response) {
        this.saving = null;
        if (response.data) {
            this.errors.record(response.data);
        }
    }

}

export default BaseForm;