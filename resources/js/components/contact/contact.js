import Form from './form';
import template from './template.html';

export default {
    data() {
        return {
            form: new Form(),
            success: false,
        }
    },
    mounted() {

    },
    methods: {
        submit() {
            let self = this;
            let form = this.form;
            form.submit()
                .then(function (response) {
                    console.log(111);
                    console.log(response);
                    self.success = true;
                });
        }
    },
    template: template,
}