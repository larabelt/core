import Errors from './errors';

class BaseForm {

    /**
     * Create a new Form instance.
     *
     * @param {object} options
     */
    constructor(options = {}) {
        this.router = options.router;
        this.errors = new Errors();
        this.saving = null;
        this.service = null;
        this.routeEditName = null;
    }

    /**
     * Fetch all relevant data for the form.
     */
    setData(data) {
        this.originalData = data;

        for (let field in data) {
            this[field] = data[field];
        }
    }

    setRouter(router) {
        this.router = router;
    }

    /**
     * Fetch all relevant data for the form.
     */
    data() {
        let data = {};

        for (let property in this.originalData) {
            data[property] = this[property];
        }

        return data;
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
        console.log('form.show()');
        console.log('form.show():id ' + id);
        return new Promise((resolve, reject) => {
            this.service.get(id)
                .then(response => {
                    console.log('form.show():then');
                    console.log(response.data);
                    this.setData(response.data);
                    console.log(this.name);
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error.response.data);
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
            console.log('form.update(): Promise');
            console.log(this.service);
            this.service.put(id, this.data())
                .then(response => {
                    this.saving = null;
                    this.setData(response.data);
                    resolve(response.data);
                })
                .catch(error => {
                    this.saving = null;
                    this.onFail(error.response.data);
                    reject(error.response.data);
                });
        });
    }

    /**
     * POST the form object
     */
    store() {
        console.log('form.store()');
        return new Promise((resolve, reject) => {
            this.saving = true;
            console.log('form.store(): Promise');
            console.log(this.service);
            this.service.post(this.data())
                .then(response => {
                    if (this.router && this.routeEditName) {
                        this.router.push({name: this.routeEditName, params: {id: response.data.id}})
                    }
                    this.saving = null;
                    this.setData(response.data);
                    resolve(response.data);
                })
                .catch(error => {
                    this.saving = null;
                    this.onFail(error.response.data);
                    reject(error.response.data);
                });
        });
    }

    /**
     * Submit the form.
     */
    submit() {
        console.log('form.submit()');
        if (this.id) {
            return this.update(this.id);
        } else {
            console.log('form.submit(): this.id = null');
            return this.store();
        }
    }

    error(field) {
        return this.errors.get(field);
    }

    /**
     * Handle a successful form submission.
     *
     * @param {object} data
     */
    onSuccess(data) {
        this.reset();
    }


    /**
     * Handle a failed form submission.
     *
     * @param {object} errors
     */
    onFail(errors) {
        this.errors.record(errors);
    }
}

export default BaseForm;