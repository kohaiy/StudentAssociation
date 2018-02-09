// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue';
import Moment from 'moment';
import ElementUI from 'element-ui';
import 'normalize.css/normalize.css';
import './assets/styles/font-awesome.scss';
import './assets/styles/element-variables.scss';
import './assets/styles/helper.scss';
import App from './App';
import router from './router';
import store from './store';

import UserService from './service/UserService';
import config from './config';

Vue.config.productionTip = false;
Vue.use(ElementUI);

Vue.prototype.moment = Moment;

// 重写错误提示，使得支持多条错误信息
Vue.prototype.$error = function z(err) {
  const errors = err.split('\n');
  const h = this.$createElement;
  this.$message({
    iconClass: 'error',
    customClass: 'el-message--error',
    message: h('div', null,
      errors.map(error => h('div', { class: 'text-danger' }, [
        h('span', { class: 'fa-times-circle' }, null),
        h('span', { style: 'margin-left: 10px;' }, error),
      ]))),
  });
};

/**
 * 进入每个页面前验证用户权限
 * 排除两种情况无需验证：
 * 1. 部分路径无需验证（登录、注册等界面）
 * 2. store user 属性不为空且验证没有过期（这里只是简单判断，涉及权限的操作后端会重新验证 token ）
 * 其它情况会使用 store 中的 token （可能为空）向后端发起请求用户信息操作，
 * 验证通过则进入后续操作，失败则会跳转到登录界面
 */
router.beforeEach((to, from, next) => {
  console.log(`to.path: ${to.path}, from: ${from.path}`);
  if (config.notAuthPaths.indexOf(to.path) > -1
    || (store.state.user && Date.now() - store.state.lastAuthTime < config.expireTime * 1000)) {
    // 1. 路径无需验证
    // 2. store 存在 user 并且验证没有过期
    next();
  } else {
    UserService.getUser()
      .then(() => {
        next();
      });
  }
});

Vue.filter('formatDate', (date = Date.now(), format = 'YYYY-MM-DD HH:mm:ss') => Moment(date).format(format));

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  components: { App },
  template: '<App/>',
});
