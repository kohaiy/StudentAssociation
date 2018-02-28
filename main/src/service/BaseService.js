import API from './../api';
import store from './../store';

export default class BaseService {
  static api = API;
  static store = store;
}
