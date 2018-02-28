const BaseController = require('./BaseController');
const UtilService = require('../service/UtilService');

class UtilController extends BaseController {
    static async getProvinces(ctx) {
        ctx.json(await UtilService.getAllProvinces());
    }

    static async getCities(ctx) {
        ctx.json(await UtilService.getCities(ctx.request.query.pid));
    }

    static async getSchools(ctx) {
        ctx.json(await UtilService.getSchools(ctx.request.query.cid));
    }
}

module.exports = UtilController;
