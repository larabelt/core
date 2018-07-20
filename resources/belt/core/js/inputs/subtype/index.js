import Config from 'belt/core/js/subtypes/config';
import html from 'belt/core/js/inputs/subtype/template.html';

export default {
    props: {
        autoset: {
            default: function () {
                return false;
            }
        },
        formKey: {
            default: function () {
                return 'form';
            }
        },
        entity_type: {
            default: function () {
                return this.$parent.entity_type;
            }
        },
    },
    data() {

        // set form
        let formKey = this.formKey ? this.formKey : 'form';
        let form = this.$parent[formKey];

        return {
            config: new Config(),
            dropdown: {},
            form: form,
        }
    },
    created() {
        this.config.setService(this.type);
        this.config.load()
            .then((response) => {
                this.dropdown = this.config.options();
                if (this.autoset) {
                    this.form.subtype = this.defaultSubtype;
                }
            });
    },
    computed: {
        defaultSubtype() {
            return _.keys(this.dropdown)[0];
        },
        type() {
            return this.entity_type ? this.entity_type : this.$parent.entity_type;
        }
    },
    template: html
}