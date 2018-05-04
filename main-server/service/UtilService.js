const mongoose = require('mongoose');
const BaseService = require('./BaseService');
const Province = require('../model/province');
const City = require('../model/city');
const School = require('../model/school');
const { sendSMS } = require('../util/sms');

class UtilService extends BaseService {

    static async sendCaptcha(phoneNumbers) {
        if (!/^1[0-9]{10}$/.test(phoneNumbers)) {
            return this.failure('手机号码不合法');
        }
        const code = this.random(Number, 4);
        try {
            const { err, res } = await sendSMS(phoneNumbers, code);
            if (err) {
                return this.failure('发送失败');
            }
            return this.success();
        } catch (e) {
            if (e.err && e.err.code === 'isv.MOBILE_NUMBER_ILLEGAL') {
                return this.failure('手机号码不合法');
            } else {
                return this.failure('发送验证码失败，请稍后重试');
            }
        }
    }

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