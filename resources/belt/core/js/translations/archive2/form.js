import BaseForm from 'belt/core/js/helpers/form';
import BaseService from 'belt/core/js/helpers/service';

class Form extends BaseForm {

    constructor(options = {}) {
        super(options);
        let baseUrl = `/api/v1/${this.entity_type}/${this.entity_id}/translations/`;
        this.service = new BaseService({baseUrl: baseUrl});

        this.setData({
            id: '',
            _auto_translate: false,
            locale: options.locale ? options.locale : '',
            translatable_column: options.translatable_column ? options.translatable_column : '',
            value: '',
        });
    }

}

export default Form;