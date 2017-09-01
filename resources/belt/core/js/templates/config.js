import BaseConfig from 'belt/core/js/helpers/config';
import BaseService from 'belt/core/js/helpers/service';

class TemplateConfig extends BaseConfig {

    constructor(options = {}) {
        super(options);
    }

    setService(morph_class, template) {
        let key = morph_class + '.' + template;
        this.service = new BaseService({baseUrl: `/api/v1/config/belt.templates/` + key});
    }

}

export default TemplateConfig;