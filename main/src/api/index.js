/* eslint-disable no-console */
import axios from 'axios';
import { Message } from 'element-ui';
import config from './config';
import router from './../router';
import store from './../store';
import globalConfig from './../config';

const api = axios.create(config);

// http request 拦截器
api.interceptors.request.use((req) => {
  // eslint-disable-next-line no-param-reassign
  req.headers.Authorization = store.state.token;
  return req;
}, error => Promise.reject(error));

// http response 拦截器
api.interceptors.response.use(
  (() => {
    if (globalConfig.isClearConsole) {
      return (res) => {
        console.clear();
        return res.data;
      };
    }
    return (res) => {
      if (res.data.status !== 0) {
        Message.error(res.data.message);
      }
      return res.data;
    };
  })(), (error) => {
    const res = error.response;
    if (!res) {
      Message.error('(500)服务器出了点意外！');
      throw error;
    }
    const isNotAuthPath = globalConfig.notAuthPaths.indexOf(router.currentRoute.path) > -1;
    if (isNotAuthPath && res.status === 401) {
      //  xxx
    } else if (!isNotAuthPath && res.status === 401) {
      // token 过期
      Message.error('登录已过期！');
      store.commit('token', null);
      store.commit('user', null);
      router.replace({
        path: '/login',
        query: {
          redirect: router.currentRoute.path,
        },
      });
    } else if (Math.floor(res.status / 100) === 5) {
      Message.error(res.data.message || '服务器出了点问题，请稍候再试！');
    } else {
      Message.error(res.data.message);
    }
    throw res;
  },
)
;

export default api;
