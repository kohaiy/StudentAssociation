import api from '../api';
// import store from '../store';

const MessageService = {
  get(opts) {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      api.get(`/messages?${opts}`)
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
   * 获取聊天用户列表
   * @returns {Promise<any>}
   */
  getMemberList() {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      api.get('/message/list')
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

  sendMessage(receiver, content) {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      api.post('/message', { receiver, content })
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

  massMessage(content) {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      api.post('/messages', { content })
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
};

export default MessageService;
