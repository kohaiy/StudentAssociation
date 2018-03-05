import api from '../api';

const UtilService = {
  getProvinces() {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      api.get('/provinces')
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
  getCities(pid) {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      let url = '/cities';
      if (pid) {
        url += `?pid=${pid}`;
      }
      api.get(url)
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
  getSchools(cid) {
    return new Promise((resolve = () => {
    }, reject = () => {
    }) => {
      let url = '/schools';
      if (cid) {
        url += `?cid=${cid}`;
      }
      api.get(url)
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
};

export default UtilService;
