import Table from 'belt/core/js/teams/table';

export default {
    namespaced: true,
    state: {
        data: [],
    },
    mutations: {
        data: (state, data) => state.data = data,
    },
    actions: {
        data: (context, data) => context.commit('data', data),
        load: ({commit, state}) => {
            let table = new Table();
            table.updateQuery({perPage: 0});
            return new Promise((resolve, reject) => {
                table.index()
                    .then(response => {
                        commit('data', {});
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
    }
};