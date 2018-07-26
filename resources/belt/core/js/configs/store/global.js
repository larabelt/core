import Service from 'belt/core/js/configs/service';

export default {
    namespaced: true,
    state() {
        return {
            data: {},
        }
    },
    mutations: {
        data: (state, options) => {
            //_.set(state.data, options.path, options.data);
            Vue.set(state.data, options.path, options.data);
        },
    },
    actions: {
        get: (context, options) => {
            let config = _.get(context.state.data, options.type + '.' + options.subtype);
            if (config) {
                return Promise.resolve(config);
            }

            let service = new Service();
            service.set(options.type, options.subtype);
            return new Promise((resolve, reject) => {
                service.load()
                    .then(config => {
                        context.commit('data', {path: options.type + '.' + options.subtype, data: config});
                        resolve(config);
                    })
                    .catch(error => {
                        reject(error);
                    })
            });
        },
        loadType: (context, type) => {
            context.commit('data', {path: type, data: {}});
            let service = new Service();
            service.set(type);
            return new Promise((resolve, reject) => {
                service.load()
                    .then(configs => {
                        context.commit('data', {path: type, data: configs});
                        resolve(configs);
                    })
                    .catch(error => {
                        reject(error);
                    })
            });
        },
    },
    getters: {
        data: state => state.data,
    }
}