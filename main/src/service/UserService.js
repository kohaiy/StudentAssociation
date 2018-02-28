import BaseService from './BaseService';

console.log(`UserServer: ${BaseService}`);

class UserService {
  /**
   * 登录 业务
   * @param username
   * @param password
   * @returns {Promise<any>}
   */
  static login(username, password) {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      this.api.post('/session', { username, password })
        .then((res) => {
          if (res.status === 0) {
            this.store.commit('token', res.data.token);
            resolve(res);
          } else {
            reject(res);
          }
        })
        .catch((error) => {
          if (error.response) reject(error.response.data);
        });
    });
  }

  /**
   * 注册 业务
   * @param username
   * @param password
   * @returns {Promise<any>}
   */
  static register(username, password) {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      this.api.post('/user', { username, password })
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
  }

  /**
   * 获取用户信息
   * @returns {Promise<any>}
   */
  static getUser() {
    return UserService.$userInfo();
  }

  static getFullUser() {
    return UserService.$userInfo('/user?logs=1');
  }

  /**
   * 用户注销登录 业务
   */
  static logout() {
    this.store.commit('user', null);
    this.store.commit('token', null);
  }

  static $userInfo(url = '/user') {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      this.api.get(url)
        .then((res) => {
          if (res.status === 0) {
            this.store.commit('lastAuthTime', Date.now());
            this.store.commit('user', res.data);
            resolve(res);
          } else {
            this.store.commit('user', null);
            reject(res);
          }
        })
        .catch(() => {
          this.store.commit('user', null);
          // reject(error.response.data);
        });
    });
  }
}

export default UserService;
