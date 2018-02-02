import Table from 'belt/core/js/roles/table';

export default {
    namespaced: true,
    modules: {},
    state: {
        data: [],
        table: new Table(),
    },
    mutations: {
        data: (state, data) => state.data = data,
    },
    actions: {
        data: (context, data) => context.commit('data', data),
        load: ({commit, dispatch, state}) => {
            return new Promise((resolve, reject) => {
                state.table.index()
                    .then(response => {
                        commit('data', []);
                        if (response.data.length) {
                            commit('data', response.data);
                        }
                        resolve(response);
                    })
                    .catch(error => {
                        reject(error);
                    })
            });
        },
    },
    getters: {
        data: state => state.data,
        table: state => state.table,
    }
};