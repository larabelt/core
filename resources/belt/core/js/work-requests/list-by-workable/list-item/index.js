import Form from 'belt/core/js/work-requests/form';
import html from 'belt/core/js/work-requests/list-by-workable/list-item/template.html';

export default {
    props: {
        workRequest: {},
        morphable_id: {
            default: function () {
                return this.$parent.morphable_id;
            }
        },
        morphable_type: {
            default: function () {
                return this.$parent.morphable_type;
            }
        },
    },
    data() {
        return {
            form: new Form(),
        }
    },
    mounted() {
        this.form.setData(this.workRequest);
    },
    template: html,
}