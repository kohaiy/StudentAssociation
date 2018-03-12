import Vue from 'vue';
import Router from 'vue-router';
import HelloWorld from '../components/HelloWorld';
// user
import UserLoginPage from '../pages/user/login/login';
import UserRegisterPage from '../pages/user/register/register';
import UserIndexPage from '../pages/user/index/index';
import UserDetailPage from '../pages/user/index/detail';
import UserSafePage from '../pages/user/index/safe';
// message
import MessageIndexPage from '../pages/message/index';
import MessageWhisperPage from '../pages/message/whisper';
import MessageSystemPage from '../pages/message/system';
// association
import AssociationIndexPage from '../pages/association/index';
import AssociationDetailPage from '../pages/association/detail';
import AssociationMemberPage from '../pages/association/member';

Vue.use(Router);

export default new Router({
  mode: 'history',
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
    {
      path: '/message',
      component: MessageIndexPage,
      children: [
        {
          path: '/',
          redirect: 'system',
        },
        {
          path: 'system',
          component: MessageSystemPage,
        },
        {
          path: 'whisper',
          component: MessageWhisperPage,
        },
      ],
    },
    {
      path: '/association',
      component: AssociationIndexPage,
      children: [
        {
          path: '/',
          component: AssociationDetailPage,
        },
        {
          path: 'member',
          component: AssociationMemberPage,
        },
      ],
    },
  ],
});
