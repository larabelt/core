import shared from 'belt/core/js/inputs/priority/shared';
import html from 'belt/core/js/inputs/priority/form/template.html';

export default {
    mixins: [shared],
    props: {
        form: {
            default: function () {
                return this.$parent.form;
            }
        },
    },
    template: html
}