import BaseForm from 'belt/core/js/helpers/form';
import BaseService from 'belt/core/js/helpers/service';

class ContactForm extends BaseForm {

    constructor(options = {}) {
        super(options);
        this.service = new BaseService({baseUrl: '/api/v1/contact/'});
        this.setData({
            name: '',
            email: '',
            comments: '',
        })
    }

}

export default ContactForm;