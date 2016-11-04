export default function install(Vue) {

    // Object.defineProperty(Vue.prototype, '$router', {
    //     get () {
    //         return this.$root._router
    //     }
    // })

    Vue.mixin({
        // beforeCreate () {
        //     console.log('hello');
        // }
    });

    Vue.hello = function () {
        // something logic ...
        console.log('hello method');
    };

    // Vue.component('router-view', View)
    // Vue.component('router-link', Link)
}