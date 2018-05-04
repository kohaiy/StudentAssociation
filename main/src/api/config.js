import Qs from 'qs';

export default {

  method: 'get', // default

  // baseURL: ' https://www.easy-mock.com/mock/5a7186068d311b0183c28670/sa',
  baseURL: 'http://localhost:3000',
  // baseURL: `${window.location.protocol}//api.${window.location.host}`,
  // transformRequest: [(data, headers) => {
  //   // Do whatever you want to transform the data
  //   console.log(headers);
  //   return data;
  // }],

  // transformResponse: [(data) => {
  //   // Do whatever you want to transform the data
  //   console.log(data);
  //   return data;
  // }],

  headers: { 'X-Requested-With': 'XMLHttpRequest' },

  params: {},

  paramsSerializer(params) {
    return Qs.stringify(params, { arrayFormat: 'brackets' });
  },

  data: {},

  timeout: 10000,

  // `withCredentials` indicates whether or not cross-site Access-Control requests
  // should be made using credentials
  withCredentials: false, // default

  responseType: 'json', // default

  maxContentLength: 2000,

  // `validateStatus` defines whether to resolve or reject the promise for a given
  // HTTP response status code. If `validateStatus` returns `true` (or is set to `null`
  // or `undefined`), the promise will be resolved; otherwise, the promise will be
  // rejected.
  validateStatus(status) {
    return status >= 200 && status < 300; // default
  },

  // `maxRedirects` defines the maximum number of redirects to follow in node.js.
  // If set to 0, no redirects will be followed.
  maxRedirects: 5, // default
};
