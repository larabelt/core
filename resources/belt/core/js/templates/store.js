import Configurator from 'belt/core/js/templates/config';

export default {
    namespaced: true,
    state: {
        config: {},
        configs: {},
        configurator: new Configurator(),
    },
    mutations: {
        setConfig: (state, options) => {
            state.config = options.config;
            _.set(state.configs, options.type + '.' + options.template, options.config);
        },
    },
    actions: {
        getConfig: (context, options) => {

            let path = options.type + '.' + options.template;
            let config = _.get(context.state.configs, path);

            if (config) {
                return Promise.resolve(config);
            }

            context.state.configurator.setService(options.type, options.template);

            return new Promise((resolve, reject) => {
                context.state.configurator.load()
                    .then(config => {
                        options.config = config;
                        context.commit('setConfig', options);
                        resolve(config);
                    })
                    .catch(error => {
                        reject(error);
                    })
            });
        },
    },
    getters: {
        config: state => {
            return state.config;
        },
        configs: state => {
            return state.configs;
        },
    }
}