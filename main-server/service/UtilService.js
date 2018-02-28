const mongoose = require('mongoose');
const BaseService = require('./BaseService');
const Province = require('../model/province');
const City = require('../model/city');
const School = require('../model/school');

class UtilService extends BaseService {
    static async getAllProvinces() {
        return this.success(await Province.find());
    }

    static async getCities(pid) {
        let query = {};
        if (pid) {
            query.pid = pid;
        }
        return this.success(await City.find(query));
    }

    static async getSchools(cid) {
        let query = {};
        if (cid) {
            query.cid = cid;
        }
        return this.success(await School.find(query));
    }
}

module.exports = UtilService;