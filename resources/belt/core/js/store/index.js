import abilities from 'belt/core/js/abilities/store';
import configs from 'belt/core/js/configs/store/global';
import locales from 'belt/core/js/locales/store';

export default new Vuex.Store({
    modules: {
        abilities: abilities,
        configs: configs,
        locales: locales,
    },
    state: {},
    mutations: {},
    getters: {},
    actions: {}
});