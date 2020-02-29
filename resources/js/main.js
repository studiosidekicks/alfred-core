import Vue from 'vue';
import Router from 'vue-router';
import routes from './router';
import App from './App.vue';
//import AlfredSpaModules from 'AlfredSpa/alfred-spa-modules.js';

Vue.use(Router);

new Vue({
    router: routes([]),
    render: h => h(App)
}).$mount("#app");