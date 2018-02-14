import Form from 'belt/core/js/users/form';
import roles from 'belt/core/js/assigned-roles/list/store';

export default {
    namespaced: true,
    modules: {
        roles,
    },
    state: {
        form: new Form(),
    },
    mutations: {
        form: (state, form) => state.form = form,
    },
    actions: {
        load: ({commit, dispatch, state}, userID) => {
            dispatch('roles/construct', {entityType: 'users', entityID: userID});
            return new Promise((resolve, reject) => {
                state.form.show(userID)
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