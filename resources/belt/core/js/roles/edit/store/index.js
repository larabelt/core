import Form from 'belt/core/js/roles/form';
import permissions from 'belt/core/js/permissions/store';

export default {
    namespaced: true,
    modules: {
        permissions,
    },
    state: {
        form: new Form(),
    },
    mutations: {
        form: (state, form) => state.form = form,
    },
    actions: {
        load: ({commit, dispatch, state}, roleID) => {
            dispatch('permissions/construct', {entityType: 'roles', entityID: roleID});
            return new Promise((resolve, reject) => {
                state.form.show(roleID)
                    .then(response => {
                        resolve(response);
                    })
                    .catch(error => {
                        reject(error);
                    })
            });
        },
        form: (context, form) => context.commit('form', form),
    },
    getters: {
        form: state => state.form,
    }
};