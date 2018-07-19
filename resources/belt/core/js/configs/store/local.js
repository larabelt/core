import Service from 'belt/core/js/configs/service';

export default {
    namespaced: true,
    state() {
        return {
            data: {},
            configKey: '',
            entity_type: '',
        }
    },
    mutations: {
        data: (state, value) => state.data = value,
        configKey: (state, value) => state.configKey = value,
        entity_type: (state, value) => state.entity_type = value,
    },
    actions: {
        data: (context, value) => context.commit('data', value),
        configKey: (context, value) => context.commit('configKey', value),
        entity_type: (context, value) => context.commit('entity_type', value),
        load: ({dispatch, commit, state}) => {
            dispatch('configs/get', {type: state.entity_type, template: state.configKey}, {root: true})
                .then((config) => {
                    commit('data', config);
                });
        },
        set: (context, options) => {
            if (options.configKey) {
                context.commit('configKey', options.configKey);
            }
            if (options.entity_type) {
                context.commit('entity_type', options.entity_type);
            }
        },
    },
    getters: {
        data: state => state.data,
    }
}