import api from '../api';
import store from '../store';

const UserService = {
  /**
   * 登录 业务
   * @param username
   * @param password
   * @returns {Promise<any>}
   */
  login(username, password) {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      api.post('/session', { username, password })
        .then((res) => {
          if (res.status === 0) {
            store.commit('token', res.data.token);
            resolve(res);
          } else {
            reject(res);
          }
        })
        .catch((error) => {
          if (error.response) reject(error.response.data);
        });
    });
  },

  /**
   * 注册 业务
   * @param username
   * @param password
   * @returns {Promise<any>}
   */
  register(username, password) {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      api.post('/user', { username, password })
        .then((res) => {
          if (res.status === 0) {
            resolve(res);
          } else {
            reject(res);
          }
        })
        .catch((error) => {
          reject(error.response.data);
        });
    });
  },

  /**
   * 获取用户信息
   * @returns {Promise<any>}
   */
  getUser() {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      api.get('/user')
        .then((res) => {
          if (res.status === 0) {
            store.commit('lastAuthTime', Date.now());
            store.commit('user', res.data);
            resolve(res);
          } else {
            store.commit('user', null);
            reject(res);
          }
        })
        .catch(() => {
          store.commit('user', null);
          // reject(error.response.data);
        });
    });
  },

  /**
   * 用户注销登录 业务
   */
  logout() {
    store.commit('user', null);
    store.commit('token', null);
  },

  /**
   * 更新密码
   * @param oldPassword
   * @param newPassword
   * @returns {Promise<any>}
   */
  updatePassword(oldPassword, newPassword) {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      api.put('/user?pwd=1', { oldPassword, newPassword })
        .then((res) => {
          if (res.status === 0) {
            resolve(res);
          } else {
            reject(res);
          }
        })
        .catch((error) => {
          reject(error.response.data);
        });
    });
  },

  updateInfo(info = {}) {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      api.put('/user', info)
        .then((res) => {
          if (res.status === 0) {
            resolve(res);
          } else {
            reject(res);
          }
        })
        .catch((error) => {
          reject(error.response.data);
        });
    });
  },

  getUserInfo(params = '') {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      api.get(`/user?${params}`)
        .then((res) => {
          if (res.status === 0) {
            resolve(res);
          } else {
            reject(res);
          }
        })
        .catch((error) => {
          reject(error.response.data);
        });
    });
  },
};

export default UserService;
