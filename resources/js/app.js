import Vue from 'vue';
import vuetify from './plugins/vuetify';
import Cookies from 'js-cookie';

import App from './views/App';
import store from './store';
import router from '@/router';
import i18n from './lang'; // Internationalization
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
  i18n,
  render: h => h(App),
});

//import '../../../../Alfred-symlink-test/resources/js/app';