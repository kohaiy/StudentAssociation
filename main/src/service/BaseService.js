import API from './../api';
import store from './../store';

class BaseService {
  static api = API;
  static store = store;
}

export default BaseService;
