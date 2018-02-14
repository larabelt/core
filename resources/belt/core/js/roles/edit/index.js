import mixin from 'belt/core/js/roles/edit/mixin';
import storeMixin from 'belt/core/js/roles/edit/store/mixin';
import form_html from 'belt/core/js/roles/edit/form.html';

export default {
    mixins: [storeMixin, mixin],
    components: {
        edit: {
            computed: {
                form() {
                    return this.$parent.role;
                },
            },
            template: form_html,
        },
    },
}