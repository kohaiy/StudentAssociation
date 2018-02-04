// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue';
import ElementUI from 'element-ui';
import 'normalize.css/normalize.css';
import './assets/styles/font-awesome.scss';
import './assets/styles/element-variables.scss';
import './assets/styles/helper.scss';
import App from './App';
import router from './router';
import API from './api';

Vue.config.productionTip = false;
Vue.use(ElementUI);
Vue.use(API);

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  components: { App },
  template: '<App/>',
});
