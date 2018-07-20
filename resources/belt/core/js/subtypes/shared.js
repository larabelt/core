import Config from 'belt/core/js/subtypes/config';

export default {
    props: {
        entity_type: {
            default: function () {
                return this.$parent.entity_type;
            }
        },
    },
    data() {
        return {
            config: new Config(),
            options: {},
        }
    },
    created() {
        this.config.setService(this.type);
        this.config.load()
            .then(() => {
                this.options = this.config.options();
            });
    },
    computed: {
        defaultSubtype() {
            return _.keys(this.options)[0];
        },
        type() {
            return this.entity_type ? this.entity_type : this.$parent.entity_type;
        },
    },
}