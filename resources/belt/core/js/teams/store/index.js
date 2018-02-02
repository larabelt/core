import Form from 'belt/core/js/teams/form';
import abilities from 'belt/core/js/permissible/abilities/store';
import roles from 'belt/core/js/permissible/roles/store';

export default {
    namespaced: true,
    modules: {
        abilities,
        roles,
    },
    state: {
        form: new Form(),
    },
    mutations: {
        form: (state, form) => state.form = form,
    },
    actions: {
        load: ({commit, dispatch, state}, teamID) => {

            dispatch('abilities/construct', {entityType: 'teams', entityID: teamID});
            dispatch('roles/construct', {entityType: 'teams', entityID: teamID});

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