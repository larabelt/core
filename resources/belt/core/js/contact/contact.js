import Form from 'belt/core/js/contact/form';
import template from 'belt/core/js/contact/template.html';

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
                    self.success = true;
                });
        }
    },
    template: template,
}