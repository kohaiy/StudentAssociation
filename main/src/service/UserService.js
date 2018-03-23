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

  getUserPublic(_id) {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      api.get(`/user/${_id}`)
        .then((res) => {
          if (res.status === 0) {
            resolve(res);
          } else {
            reject(res);
          }
        })
        .catch((error) => {
          reject(error.data.message);
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
    }) => {
      api.put('/user?pwd=1', { oldPassword, newPassword })
        .then((res) => {
          resolve(res);
        });
    });
  },

  /**
   * 加入同乡会
   * @param aid
   * @returns {Promise<any>}
   */
  joinAssociation(aid) {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      api.put('/user?association=1', { aid })
        .then((res) => {
          if (res.status === 0) {
            resolve(res);
          } else {
            reject(res);
          }
        })
        .catch((error) => {
          reject(error.data.message);
        });
    });
  },

  quitAssociation() {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      api.put('/user?association=quit')
        .then((res) => {
          if (res.status === 0) {
            resolve(res);
          } else {
            reject(res);
          }
        })
        .catch((error) => {
          reject(error.data.message);
        });
    });
  },

  /**
   * 更新用户信息
   * @param info
   * @returns {Promise<any>}
   */
  updateInfo(info = {}) {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      api.put('/user', info)
        .then((res) => {
          if (res.status === 0) {
            resolve(res);
          } else {
            reject(res.message);
          }
        })
        .catch((error) => {
          reject(error.data.message);
        });
    });
  },

  /**
   * 获取用户详细信息
   * @param params
   * @returns {Promise<any>}
   */
  getUserInfo(params = '') {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      api.get(`/user?${params}`)
        .then((res) => {
          if (res.status === 0) {
            resolve(res);
          } else {
            reject(res.message);
          }
        })
        .catch((error) => {
          reject(error.data.message);
        });
    });
  },
};

export default UserService;
