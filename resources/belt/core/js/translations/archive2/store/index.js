import Form from 'belt/core/js/translations/form';
import Table from 'belt/core/js/translations/table';

export default {
    namespaced: true,
    state() {
        return {
            translations: [],
            entity_id: '',
            entity_type: '',
            visibility: {},
        }
    },
    mutations: {
        translations: (state, translations) => state.translations = translations,
        entity_id: (state, value) => state.entity_id = value,
        entity_type: (state, value) => state.entity_type = value,
        visibility: (state, values) => state.visibility = Object.assign({}, state.visibility, {[values.column]: values.visibility}),
    },
    actions: {
        translations: (context, translations) => context.commit('translations', translations),
        load: (context) => {
            //context.commit('translations', []);
            let table = new Table({entity_type: context.state.entity_type, entity_id: context.state.entity_id});
            return new Promise((resolve, reject) => {
                table.index()
                    .then(response => {
                        context.dispatch('pushTranslations', response.data);
                        resolve(response);
                    })
                    .catch(error => {
                        reject(error);
                    })
            });
        },
        pushTranslation: ({state}, values) => {
            let translation = state.translations.find(translation => translation.locale === values.locale && translation.translatable_column === values.translatable_column);
            if (!translation) {
                translation = new Form({entity_type: state.entity_type, entity_id: state.entity_id});
                //translation.mergeData(values);
                state.translations.push(translation);
            }
            translation.mergeData(values);
            // for (let field in values) {
            //     Vue.set(translation, field, values[field]);
            // }
        },
        pushTranslations: (context, translations) => {
            _.each(translations, (translation) => {
                context.dispatch('pushTranslation', translation);
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
        translation: (state) => (values) => {
            if (values.id) {
                return state.translations.find(translation => translation.id === values.id);
            }
            if (values.locale && values.translatable_column) {
                let translation = state.translations.find(translation => translation.locale === values.locale && translation.translatable_column === values.translatable_column);
                if (!translation) {

                }
                return translation;
            }
        },
        translations: (state) => (values) => {
            if (values.translatable_column) {
                return _.filter(state.translations, {translatable_column: values.translatable_column});
            }
            return state.translations;
        },
        visibility: state => state.visibility,
    }
}