import Form from 'belt/core/js/permissions/form';
import Table from 'belt/core/js/permissions/table';

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
        allow: ({dispatch, state}, params) => {
            let form = new Form();
            form.setService(state.entityType, state.entityID);
            form.ability_id = params.ability_id;
            return new Promise((resolve, reject) => {
                form.store()
                    .then(response => {
                        Vue.set(state.data, response.id, response);
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
                            _.forEach(response, function (ability) {
                                Vue.set(state.data, ability.id, ability);
                            });
                        }
                        resolve(response);
                    })
                    .catch(error => {
                        reject(error);
                    })
            });
        },
        disallow: ({state, dispatch}, params) => {
            let form = new Form();
            form.setService(state.entityType, state.entityID);
            return new Promise((resolve, reject) => {
                form.destroy(params.ability_id)
                    .then(response => {
                        Vue.delete(state.data, params.ability_id);
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