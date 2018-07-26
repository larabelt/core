import BaseConfig from 'belt/core/js/helpers/config';
import BaseService from 'belt/core/js/helpers/service';

class SubtypeConfig extends BaseConfig {

    constructor(options = {}) {
        super(options);
    }

    setService(key) {
        let baseUrl = '/api/v1/config/belt.subtypes/' + key;
        this.service = new BaseService({baseUrl: baseUrl});
    }

    options() {

        let subtypes = {};

        for (let key in this.data) {
            let config = this.data[key];
            subtypes[key] = config['label'] ? config['label'] : key;
        }

        return subtypes;
    }

}

export default SubtypeConfig;