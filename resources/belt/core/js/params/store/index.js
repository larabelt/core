import Table from 'belt/core/js/params/table';

export default {
    namespaced: true,
    state() {
        return {
            config: {},
            data: {},
            morph_id: '',
            morph_type: '',
        }
    },
    mutations: {
        config: (state, value) => state.config = value,
        data: (state, value) => state.data = value,
        morph_id: (state, value) => state.morph_id = value,
        morph_type: (state, value) => state.morph_type = value,
    },
    actions: {
        config: (context, value) => context.commit('config', value),
        data: (context, value) => context.commit('data', value),
        load: (context) => {
            context.commit('data', {});
            let table = new Table({morphable_type: context.state.morph_type, morphable_id: context.state.morph_id});
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
        set: (context, options) => {
            if (options.morph_type) {
                context.commit('morph_type', options.morph_type);
            }
            if (options.morph_id) {
                context.commit('morph_id', options.morph_id);
            }
        },
    },
    getters: {
        config: state => state.config,
        data: state => state.data,
    }
}