import store from 'belt/core/js/templates/store';

export default {
    data() {
        return {
            config_type: '',
            config_template: '',
        }
    },
    computed: {
        config() {
            //return _.get(this.configs, this.configPath);
            return this.$store.getters['templates/config'];
        },
        configPath() {
            return this.config_type + '.' + this.config_template;
        },
        configs() {
            return this.$store.getters['templates/configs'];
        },
    },
    beforeCreate() {
        if (!this.$store.state.templates) {
            this.$store.registerModule('templates', store);
        }
    },
    methods: {
        getTemplateConfig(type, template) {
            return new Promise((resolve, reject) => {
                this.$store.dispatch('templates/getConfig', {type: type, template: template})
                    .then(config => {
                        resolve(config);
                    })
                    .catch(error => {
                        reject(error);
                    })
            });
        },
    },
}