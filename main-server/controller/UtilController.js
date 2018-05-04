const BaseController = require('./BaseController');
const UtilService = require('../service/UtilService');
const qiniu = require('../util/qiniu');
const config = require('../config');
const qiniuConfig = require('../config/qiniu');
const click = require('../util/geetest');

class UtilController extends BaseController {

    static async sms(ctx) {
        const { phoneNumbers } = ctx.request.query;
        ctx.json(await UtilService.sendCaptcha(phoneNumbers));
    }

    static async getProvinces(ctx) {
        ctx.json(await UtilService.getAllProvinces());
    }

    static async getCities(ctx) {
        ctx.json(await UtilService.getCities(ctx.request.query.pid));
    }

    static async getSchools(ctx) {
        ctx.json(await UtilService.getSchools(ctx.request.query.cid));
    }

    static async upload(ctx) {
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

    static async geetestGet(ctx) {
        const data = await UtilController.geetestGetRegister();
        ctx.session.fallback = false;
        ctx.json({ status: 0, code: 200, data });
    }

    static geetestGetRegister() {
        return new Promise((resolve, reject) => {
            // 向极验申请每次验证所需的challenge
            click.register(null, function (err, data) {
                console.log(err, data);
                if (err) {
                    reject(err);
                }

                if (!data.success) {
                    reject(data);
                } else {
                    // 正常模式
                    resolve(data);
                }
            });
        });
    }

    static async geetestPost(ctx) {
        const result = await UtilController.geetestPostRegister(ctx);
        if (result) {
            ctx.json({
                status: -1,
                code: 500,
                message: '二次验证失败',
            });
        } else {
            ctx.json({
                status: 0,
                code: 200,
                message: '验证成功',
            });
        }
    }

    static geetestPostRegister(ctx) {
        return new Promise((resolve, reject) => {
            // 对ajax提供的验证凭证进行二次验证
            click.validate(ctx.session.fallback,
                ctx.request.body,
                function (err, success) {

                    if (err) {
                        // 网络错误
                        reject(err);

                    } else if (!success) {

                        // 二次验证失败
                        reject(err);
                    } else {

                        resolve();
                    }
                });
        });
    }
}

module.exports = UtilController;
