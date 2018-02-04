/* eslint-disable no-console */
import axios from 'axios';
import { Message } from 'element-ui';
import config from './config';
import router from './../router';

const api = axios.create(config);

// http request 拦截器
api.interceptors.request.use((req) => {
  // console.log('request');
  // Message.error('request');
  if (window.localStorage.ACCESS_TOKEN) {
    // eslint-disable-next-line no-param-reassign
    req.headers.Authorization = window.localStorage.ACCESS_TOKEN;
  } else {
    // eslint-disable-next-line no-param-reassign
    req.headers.Authorization = 'Bearer';
  }
  return req;
}, error => Promise.reject(error));

// http response 拦截器
api.interceptors.response.use((res) => {
  // Message.error('response');
  if (res.status === 401) {
    // token 过期
    Message.error('登录已过期！');
    window.localStorage.removeItem('ACCESS_TOKEN');
    router.replace({
      path: '/login',
      query: {
        redirect: router.currentRoute.fullPath,
      },
    });
  }
  return res;
}, () => {
  Message.error('服务器出了点意外！');
});

export default {
  install(Vue) {
    // eslint-disable-next-line no-param-reassign
    Vue.prototype.api = api;
  },
};
