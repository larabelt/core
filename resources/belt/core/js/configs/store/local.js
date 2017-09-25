import Service from 'belt/core/js/configs/service';

export default {
    namespaced: true,
    state: {
        data: {},
        configKey: '',
        morphType: '',
    },
    mutations: {
        data: (state, value) => state.data = value,
        configKey: (state, value) => state.configKey = value,
        morphType: (state, value) => state.morphType = value,
    },
    actions: {
        data: (context, value) => context.commit('data', value),
        configKey: (context, value) => context.commit('configKey', value),
        morphType: (context, value) => context.commit('morphType', value),
        load: ({dispatch, commit, state}) => {
            dispatch('configs/get', {type: state.morphType, template: state.configKey}, {root: true})
                .then((config) => {
                    commit('data', config);
                });
        },
        set: (context, options) => {
            if (options.configKey) {
                context.commit('configKey', options.configKey);
            }
            if (options.morphType) {
                context.commit('morphType', options.morphType);
            }
        },
    },
    getters: {
        data: state => state.data,
    }
}