import BaseForm from 'belt/core/js/helpers/form';
import BaseService from 'belt/core/js/helpers/service';

class Form extends BaseForm {

    constructor(options = {}) {
        super(options);
        this.service = new BaseService({baseUrl: '/api/v1/users/'});
        this.setData({
            is_opted_in: '',
            first_name: '',
            last_name: '',
            email: '',
            password: '',
            password_confirmation: '',
        });
    }

    // splitName() {
    //
    //     this.first_name = '';
    //     this.last_name = '';
    //
    //     let names = this.name.split(' ');
    //
    //     for (let i = 0; i < names.length; i++) {
    //
    //         let name = names[i].replace(/^\s*/, "").replace(/\s*$/, "");
    //
    //         if (i === 0) {
    //             this.first_name = name;
    //         } else {
    //             this.last_name = this.last_name + name + ' ';
    //         }
    //     }
    // }

}

export default Form;