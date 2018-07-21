import api from '../api';

export default {
  get(opts) {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      api.get(`/bus?${opts}`)
        .then((res) => {
          if (res.status === 0) {
            resolve(res);
          } else {
            reject(res);
          }
        })
        .catch((error) => {
          if (error.data) reject(error.data);
        });
    });
  },
  create(info) {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      api.post('/bus', info)
        .then((res) => {
          if (res.status === 0) {
            resolve(res);
          } else {
            reject(res);
          }
        })
        .catch((error) => {
          if (error.data) reject(error.data);
        });
    });
  },
  update(info) {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      api.put('/ticket', info)
        .then((res) => {
          if (res.status === 0) {
            resolve(res);
          } else {
            reject(res);
          }
        })
        .catch((error) => {
          if (error.data) reject(error.data);
        });
    });
  },
  delete(id) {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      api.delete(`/ticket/${id}`)
        .then((res) => {
          if (res.status === 0) {
            resolve(res);
          } else {
            reject(res);
          }
        })
        .catch((error) => {
          if (error.data) reject(error.data);
        });
    });
  },
};
