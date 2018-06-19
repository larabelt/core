import Service from 'belt/core/js/helpers/service';

export default {
    namespaced: true,
    state: {
        data: {},
    },
    mutations: {
        data: (state, data) => state.data = data,
    },
    actions: {
        can: ({dispatch, state}, params) => {

            let uri = [
                '/api',
                'v1',
                params.entity_type,
                params.entity_id,
                'access/',
            ].join('/');

            let service = new Service({baseUrl: uri});
            let url = service.url(params.ability + '/' + params.args);
            let key = params.entity_type + params.entity_id;

            if (params.entity_id == '[auth.id]') {
                key = 'auth';
            }

            return new Promise((resolve, reject) => {
                service.submit('get', url)
                    .then(response => {

                        let access = _.get(state.data, key, {});

                        access = _.set(access, params.args + '.' + params.ability, response.data);

                        Vue.set(state.data, key, access);

                        resolve(response);
                    })
                    .catch(error => {
                        reject(error);
                    })
            });
        },
        data: (context, data) => context.commit('data', data),
    },
    getters: {
        data: state => state.data,
    }
};