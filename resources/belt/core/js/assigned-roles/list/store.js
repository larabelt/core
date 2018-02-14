import Form from 'belt/core/js/assigned-roles/form';
import Table from 'belt/core/js/assigned-roles/table';

export default {
    namespaced: true,
    state: {
        data: {},
        entityType: '',
        entityID: '',
    },
    mutations: {
        data: (state, data) => state.data = data,
        entityType: (state, entityType) => state.entityType = entityType,
        entityID: (state, entityID) => state.entityID = entityID,
    },
    actions: {
        assign: ({dispatch, state}, id) => {
            let form = new Form();
            form.setService(state.entityType, state.entityID);
            form.id = id;
            return new Promise((resolve, reject) => {
                form.store()
                    .then(response => {
                        dispatch('load');
                        resolve(response);
                    })
                    .catch(error => {
                        reject(error);
                    })
            });
        },
        construct: ({commit, state}, params) => {
            commit('entityType', params.entityType);
            commit('entityID', params.entityID);
        },
        data: (context, data) => context.commit('data', data),
        entityType: (context, entityType) => context.commit('entityType', entityType),
        entityID: (context, entityID) => context.commit('entityID', entityID),
        load: ({commit, state}) => {
            let table = new Table();
            table.setService(state.entityType, state.entityID);
            return new Promise((resolve, reject) => {
                table.index()
                    .then(response => {
                        commit('data', {});
                        if (response.length) {
                            _.forEach(response, function (role) {
                                Vue.set(state.data, role.name, role);
                            });
                        }
                        resolve(response);
                    })
                    .catch(error => {
                        reject(error);
                    })
            });
        },
        retract: ({state, dispatch}, id) => {
            let form = new Form();
            form.setService(state.entityType, state.entityID);
            return new Promise((resolve, reject) => {
                form.destroy(id)
                    .then(response => {
                        dispatch('load');
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