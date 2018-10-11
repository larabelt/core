import baseInput from 'belt/core/js/inputs/shared';
import storeAdapter from 'belt/core/js/translations/store/adapter';
import html from 'belt/core/js/translations/inputs/addon/template.html';

export default {
    mixins: [baseInput, storeAdapter],
    props: {
        translatable_type: {
            default: function () {
                return this.$parent.form.morph_class;
            }
        },
        translatable_id: {
            default: function () {
                return this.$parent.form.id;
            }
        },
    },
    methods: {
        toggle() {
            this.toggleVisibility(this.column);
        }
    },
    template: html
}