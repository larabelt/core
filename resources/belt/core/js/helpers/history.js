class History {

    /**
     * Create a new Form instance.
     *
     * @param {object} options
     */
    constructor(options = {}) {

    }

    parseGroup(group) {
        let value = localStorage.getItem(group);

        value = value === null ? '{}' : value;

        return JSON.parse(value);
    }

    set (group, path, value) {

        let object = this.parseGroup(group);

        _.set(object, path, value);

        localStorage.setItem(group, JSON.stringify(object));
    }

    get (group, path, _default) {

        let object = this.parseGroup(group);

        let result = _.get(object, path, _default);

        return result;
    }

}

export default History;