import Vue from 'vue';
import Router from 'vue-router';
import HelloWorld from './../components/HelloWorld';
// user
import UserLoginPage from './../pages/user/login/login';
import UserRegisterPage from './../pages/user/register/register';

Vue.use(Router);

export default new Router({
  routes: [
    {
      path: '/',
      name: 'HelloWorld',
      component: HelloWorld,
    },
    {
      path: '/login',
      name: 'login',
      component: UserLoginPage,
    },
    {
      path: '/register',
      name: 'register',
      component: UserRegisterPage,
    },
  ],
});
