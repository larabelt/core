import Form from 'belt/core/js/translations/form';
import Table from 'belt/core/js/translations/table';

export default {
    namespaced: true,
    state() {
        return {
            config: {},
            data: [],
            entity_id: '',
            entity_type: '',
            visibility: {},
        }
    },
    mutations: {
        config: (state, value) => state.config = value,
        data: (state, translations) => {
            let forms = [];
            _.each(translations, (translation) => {
                let form = new Form({entity_type: state.entity_type, entity_id: state.entity_id});
                form.setData(translation);
                forms.push(form);
            });
            state.data = forms;
        },
        entity_id: (state, value) => state.entity_id = value,
        entity_type: (state, value) => state.entity_type = value,
        visibility: (state, values) => state.visibility = Object.assign({}, state.visibility, {[values.column]: values.visibility}),
    },
    actions: {
        config: (context, value) => context.commit('config', value),
        data: (context, value) => context.commit('data', value),
        load: (context) => {
            context.commit('data', []);
            let table = new Table({entity_type: context.state.entity_type, entity_id: context.state.entity_id});
            return new Promise((resolve, reject) => {
                table.index()
                    .then(response => {
                        context.commit('config', response.config);
                        context.commit('data', response.data);
                        resolve(response);
                    })
                    .catch(error => {
                        reject(error);
                    })
            });
        },
        set: (context, options) => {
            if (options.entity_type) {
                context.commit('entity_type', options.entity_type);
            }
            if (options.entity_id) {
                context.commit('entity_id', options.entity_id);
            }
        },
        toggleVisibility: (context, column) => {
            context.commit('visibility', {column: column, visibility: !_.get(context.state.visibility, column, false)});
        },
    },
    getters: {
        config: state => state.config,
        data: state => state.data,
        visibility: state => state.visibility,
    }
}