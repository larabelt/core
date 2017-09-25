import Table from 'belt/core/js/paramables/table';

export default {
    namespaced: true,
    state: {
        data: {},
        morphID: '',
        morphType: '',
    },
    mutations: {
        data: (state, value) => state.data = value,
        morphID: (state, value) => state.morphID = value,
        morphType: (state, value) => state.morphType = value,
    },
    actions: {
        data: (context, value) => context.commit('data', value),
        load: (context) => {
            context.commit('data', {});
            let table = new Table({morphable_type: context.state.morphType, morphable_id: context.state.morphID});
            return new Promise((resolve, reject) => {
                table.index()
                    .then(response => {
                        context.commit('data', response.data);
                        resolve(response);
                    })
                    .catch(error => {
                        reject(error);
                    })
            });
        },
        set: (context, options) => {
            if (options.morphType) {
                context.commit('morphType', options.morphType);
            }
            if (options.morphID) {
                context.commit('morphID', options.morphID);
            }
        },
    },
    getters: {
        data: state => state.data,
    }
}