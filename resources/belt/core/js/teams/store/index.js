import Form from 'belt/core/js/teams/form';

export default {
    namespaced: true,
    state: {
        form: new Form(),
    },
    mutations: {
        form: (state, form) => state.form = form,
    },
    actions: {
        load: ({commit, dispatch, state}, teamID) => {
            return new Promise((resolve, reject) => {
                state.form.show(teamID)
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