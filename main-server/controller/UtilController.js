const BaseController = require('./BaseController');
const UtilService = require('../service/UtilService');
const qiniu = require('../util/qiniu');
const config = require('../config');
const qiniuConfig = require('../config/qiniu');

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

    static async update(ctx) {
        const result = {
            status: 0
        };
        if (config.isQiniu) {
            const { respErr, respBody, respInfo } = await qiniu(ctx.req.file.path, ctx.req.file.filename);
            if (respErr) {
                result.status = -1;
                result.data = respBody;
            } else {
                result.data = qiniuConfig.domain + '/' + respBody.key + '&100x100';
            }
        } else {
            result.data = 'http://localhost:3000/uploads/' + ctx.req.file.filename//返回文件名
        }
        ctx.body = result;
    }
}

module.exports = UtilController;
