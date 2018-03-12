export default {
  // 用户登录过期时间
  expireTime: 2 * 60 * 60,
  // 无需验证用户权限的路径
  notAuthPaths: [
    '/login',
    '/register',
  ],
  isClearConsole: false,
  loadingDelayTime: 400,
};
