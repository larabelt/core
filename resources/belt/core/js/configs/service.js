import BaseConfig from 'belt/core/js/helpers/config';
import BaseService from 'belt/core/js/helpers/service';

class Config extends BaseConfig {

    constructor(options = {}) {
        super(options);
    }

    set(morph_class, template) {

        let baseUrl = '/api/v1/config/belt.templates/' + morph_class;
        if (template) {
            baseUrl = baseUrl + '.' + template;
        }

        this.service = new BaseService({baseUrl: baseUrl});
    }

}

export default Config;