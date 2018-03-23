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
      // name: 'HelloWorld',
      redirect: '/user',
      component: HelloWorld,
    },
    {
      path: '/login',
      name: '用户登录中心',
      component: UserLoginPage,
    },
    {
      path: '/register',
      name: '用户注册中心',
      component: UserRegisterPage,
    },
    {
      path: '/user',
      component: UserIndexPage,
      children: [
        {
          path: '/',
          name: '我的信息',
          component: UserDetailPage,
        },
        {
          path: 'safe',
          name: '安全中心',
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
          name: '系统通知',
          component: MessageSystemPage,
        },
        {
          path: 'whisper',
          name: '我的消息',
          component: MessageWhisperPage,
        },
        {
          path: 'whisper/:id',
          name: '聊天讯息',
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
          name: '同乡会基本信息',
          component: AssociationDetailPage,
        },
        {
          path: 'member',
          name: '同乡会成员信息',
          component: AssociationMemberPage,
        },
      ],
    },
  ],
});
