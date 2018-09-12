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
        allowed_types: {
            default: function () {
                return [];
            }
        },
    },
    data() {

        // set form
        let formKey = this.formKey ? this.formKey : 'form';
        let form = this.$parent[formKey];

        return {
            config: new Config(),
            options: {},
            form: form,
        }
    },
    created() {
        this.config.setService(this.type);
        this.config.load()
            .then(() => {
                this.options = this.config.options();
                if (this.autoset && !this.form.subtype) {
                    this.form.subtype = this.defaultSubtype;
                }
            });
    },
    computed: {
        defaultSubtype() {
            return _.keys(this.dropdown)[0];
        },
        dropdown() {
            let options = this.options;
            if (this.allowed_types.length) {
                options = {};
                _.forOwn(this.options, (option, key) => {
                    if (this.allowed_types.includes(key)) {
                        options[key] = option;
                    }
                });
            }
            return options;
        },
        showDropdown() {
            return _.size(this.dropdown) > 1;
        },
        type() {
            return this.entity_type ? this.entity_type : this.$parent.entity_type;
        }
    },
    template: html
}