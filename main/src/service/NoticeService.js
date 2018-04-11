import api from '../api';

const NoticeService = {
  getNotices(opts) {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      api.get(`/notices?${opts}`)
        .then((res) => {
          if (res.status === 0) {
            resolve(res);
          } else {
            reject(res);
          }
        })
        .catch((error) => {
          reject(error);
        });
    });
  },
  createNotice(content, images) {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      api.post('/notice', {
        content, images,
      }).then((res) => {
        if (res.status === 0) {
          resolve(res);
        } else {
          reject(res);
        }
      }).catch((error) => {
        reject(error);
      });
    });
  },
  deleteNotice(_id) {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      api.delete(`/notice/${_id}`).then((res) => {
        if (res.status === 0) {
          resolve(res);
        } else {
          reject(res);
        }
      }).catch((error) => {
        reject(error);
      });
    });
  },
  updateNotice(_id, opts) {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      api.put(`/notice/${_id}?${opts}`).then((res) => {
        if (res.status === 0) {
          resolve(res);
        } else {
          reject(res);
        }
      }).catch((error) => {
        reject(error);
      });
    });
  },
};

export default NoticeService;
