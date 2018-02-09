import Vue from 'vue';
import Router from 'vue-router';
import HelloWorld from './../components/HelloWorld';
// user
import UserLoginPage from './../pages/user/login/login';
import UserRegisterPage from './../pages/user/register/register';
import UserIndexPage from './../pages/user/index/index';
import UserDetailPage from './../pages/user/index/detail';
import UserSafePage from './../pages/user/index/safe';

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
    {
      path: '/user',
      component: UserIndexPage,
      children: [
        {
          path: '/',
          name: 'detail',
          component: UserDetailPage,
        },
        {
          path: 'safe',
          name: 'safe',
          component: UserSafePage,
        },
      ],
    },
  ],
});
