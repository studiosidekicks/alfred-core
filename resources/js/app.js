import Vue from 'vue';
import vuetify from './plugins/vuetify';

import App from './views/App';
import store from './store';
import router from '@/router';
import '@/permission'; // permission control

import * as filters from './filters'; // global filters

// register global utility filters.
Object.keys(filters).forEach(key => {
  Vue.filter(key, filters[key]);
});

Vue.config.productionTip = false;

new Vue({
  vuetify,
  el: '#app',
  router,
  store,
  render: h => h(App),
});