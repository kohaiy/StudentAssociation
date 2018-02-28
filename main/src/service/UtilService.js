import BaseService from './BaseService';
import UserService from './UserService';

// const BaseService2 = require('./BaseService');

console.log(typeof BaseService);
console.log(UserService);

class UtilService extends BaseService {
  static hello() {
    console.log('hello');
  }
}

export default UtilService;
