import Table from 'belt/core/js/abilities/table';

export default {
    namespaced: true,
    state: {
        data: [],
    },
    mutations: {
        data: (state, data) => state.data = data,
    },
    actions: {
        construct: ({dispatch, state}) => {
            if (_.isEmpty(state.data)) {
                dispatch('load');
            }
        },
        data: (context, data) => context.commit('data', data),
        load: ({commit, state}) => {
            let table = new Table();
            return new Promise((resolve, reject) => {
                table.index()
                    .then(response => {
                        //commit('data', {});
                        commit('data', []);
                        if (response.data.length) {
                            // _.forEach(response.data, function (ability) {
                            //     Vue.set(state.data, ability.id, ability);
                            // });
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