import Table from 'belt/core/js/params/table';

export default {
    namespaced: true,
    state() {
        return {
            config: {},
            data: [],
            entity_id: '',
            entity_type: '',
        }
    },
    mutations: {
        config: (state, value) => state.config = value,
        data: (state, value) => state.data = value,
        entity_id: (state, value) => state.entity_id = value,
        entity_type: (state, value) => state.entity_type = value,
    },
    actions: {
        config: (context, value) => context.commit('config', value),
        data: (context, value) => context.commit('data', value),
        load: (context) => {
            context.commit('data', []);
            let table = new Table({entity_type: context.state.entity_type, entity_id: context.state.entity_id});
            return new Promise((resolve, reject) => {
                table.index()
                    .then(response => {
                        context.commit('config', response.config);
                        context.commit('data', response.data);
                        resolve(response);
                    })
                    .catch(error => {
                        reject(error);
                    })
            });
        },
        pushParam: ({state}, value) => {
            let param = state.data.find(param => param.key === value.locale);
            if (!param) {
                state.data.push(value);
            }
        },
        pushParams: (context, params) => {
            _.each(params, (param) => {
                context.dispatch('pushParam', param);
            });
        },
        set: (context, options) => {
            if (options.entity_type) {
                context.commit('entity_type', options.entity_type);
            }
            if (options.entity_id) {
                context.commit('entity_id', options.entity_id);
            }
        },
    },
    getters: {
        config: state => state.config,
        data: state => state.data,
    }
}