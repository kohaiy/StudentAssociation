import api from '../api';

const CharteredService = {
  getById(id) {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      api.get(`/chartered?id=${id}`)
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
  getAll() {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      api.get('/chartereds')
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
      api.post('/chartered', info)
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
      api.put('/chartered', info)
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

export default CharteredService;
