import api from '../api';

const TicketService = {
  get(opts) {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      api.get(`/ticket?${opts}`)
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
      api.post('/ticket', info)
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

export default TicketService;
