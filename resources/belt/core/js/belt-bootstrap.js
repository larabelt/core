import Vuex from 'vuex';
import VueResource from 'vue-resource';
import VueRouter from 'vue-router';

import 'admin-lte';
import 'belt/core/js/adminlte/helper';
import 'bootstrap-sass';

global.Vuex = Vuex;
global.VueResource = VueResource;
global.VueRouter = VueRouter;

axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest'
};

Vue.use(Vuex);
Vue.use(VueResource);
Vue.use(VueRouter);