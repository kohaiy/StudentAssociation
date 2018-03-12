import api from '../api';
// import store from '../store';

const AssociationService = {
  /**
   * 通过学校 id 获取同乡会列表
   * @param schoolId
   * @returns {Promise<any>}
   */
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

  getById(id, opts) {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      api.get(`/association/${id}?${opts}`)
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
          if (error.response) reject(error.response.data);
        });
    });
  },
};

export default AssociationService;
