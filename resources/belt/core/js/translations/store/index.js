import Form from 'belt/core/js/translations/form';
import Table from 'belt/core/js/translations/table';

export default {
    namespaced: true,
    state() {
        return {
            translations: [],
            entity_id: '',
            entity_type: '',
            visible: false,
        }
    },
    mutations: {
        translations: (state, translations) => state.translations = translations,
        entity_id: (state, value) => state.entity_id = value,
        entity_type: (state, value) => state.entity_type = value,
        visible: (state, value) => state.visible = value,
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
        toggleVisibility: (context) => {
            context.commit('visible', !context.state.visible);
        },
        setVisibility: (context, value) => {
            context.commit('visible', value);
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
        visible: state => state.visible,
    }
}