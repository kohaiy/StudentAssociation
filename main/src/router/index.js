import Vue from 'vue';
import Router from 'vue-router';
import IndexPage from '../pages/index/index';
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
import AssociationNoticePage from '../pages/association/notice';
import AssociationMemberPage from '../pages/association/member';
import AssociationManagerPage from '../pages/association/manager';
import AssociationBusManagerPage from '../pages/association/manager/charteredBus';

Vue.use(Router);

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: '首页',
      component: IndexPage,
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
          name: '我的同乡会',
          component: AssociationDetailPage,
        },
        {
          path: 'notice',
          name: '同乡会公告中心',
          component: AssociationNoticePage,
        },
        {
          path: 'member',
          name: '同乡会成员信息',
          component: AssociationMemberPage,
        },
        {
          path: 'manager',
          name: '同乡会管理中心',
          component: AssociationManagerPage,
        },
        {
          path: 'bus-manager',
          name: '同乡会包车管理',
          component: AssociationBusManagerPage,
        },
      ],
    },
  ],
});
