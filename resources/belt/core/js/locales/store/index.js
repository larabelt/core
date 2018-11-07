export default {
    namespaced: true,
    state() {
        return {
            canAutoTranslate: false,
            initialized: false,
            fallbackLocale: '',
            locale: [],
            locales: [],
        }
    },
    mutations: {
        canAutoTranslate: (state, value) => state.canAutoTranslate = value,
        initialized: (state, value) => state.initialized = value,
        fallbackLocale: (state, value) => state.fallbackLocale = value,
        locale: (state, value) => state.locale = value,
        locales: (state, value) => state.locales = value,
    },
    actions: {
        setCanAutoTranslate: (context, canAutoTranslate) => context.commit('canAutoTranslate', canAutoTranslate),
        setInitialized: (context, initialized) => context.commit('initialized', initialized),
        setFallbackLocale: (context, fallbackLocale) => context.commit('fallbackLocale', fallbackLocale),
        setLocale: (context, locale) => context.commit('locale', locale),
        setLocales: (context, locales) => context.commit('locales', locales),
    },
    getters: {
        canAutoTranslate: state => state.canAutoTranslate,
        initialized: state => state.initialized,
        fallbackLocale: state => state.fallbackLocale,
        locale: state => state.locale,
        locales: state => state.locales,
    },
}