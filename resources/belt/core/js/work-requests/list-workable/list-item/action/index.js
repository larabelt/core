import Form from 'belt/core/js/work-requests/form';
import html from 'belt/core/js/work-requests/list-workable/list-item/action/template.html';

export default {
    props: {
        label: '',
        transition: {},
        workRequest: {
            default: function () {
                return this.$parent.workRequest;
            }
        },
    },
    data() {
        return {
            form: new Form(),
        }
    },
    computed: {

    },
    methods: {
        humanize(str) {
            str = _.replace(str, '-', ' ');
            str = _.replace(str, '_', ' ');
            return str;
        },
        submit() {
            this.form.transition = this.label;
            this.form.submit();
        },
    },
    mounted() {
        let data = this.workRequest;
        data.transition = this.label;
        this.form.setData(data);
    },
    template: html,
}