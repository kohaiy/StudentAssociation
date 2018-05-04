import api from '../api';
// import store from '../store';

const AssociationService = {

  getBySchoolId(schoolId) {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      api.get(`/associations/${schoolId}`)
        .then((res) => {
          if (res.status === 0) {
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

  getById(opts) {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      api.get(`/association?${opts}`)
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

  createAssociation(data = {}) {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      api.post('/association', data)
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

  getMembers() {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      api.get('/association/members')
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

  doAction(action, id) {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      api.put(`/association?action=${action}`, { id })
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

  updateInfo(info) {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      api.put('/association?action=info', info)
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

export default AssociationService;
