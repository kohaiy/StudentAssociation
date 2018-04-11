const BaseController = require('./BaseController');
const NoticeService = require('../service/NoticeService');
const SessionService = require('../service/SessionService');

class NoticeController extends BaseController {
    static async get(ctx) {
        const token = ctx.header.authorization;
        let result = await SessionService.validateToken(token);
        if (result.status === 0) {
            result = await NoticeService.getNotices(result.data._id, ctx.request.query.all);
        }
        ctx.json(result);
    }
    static async create(ctx) {
        const token = ctx.header.authorization;
        let result = await SessionService.validateToken(token);
        if (result.status === 0) {
            result = await NoticeService.createNotice(result.data._id, ctx.request.body.content, ctx.request.body.images);
        }
        ctx.json(result);
    }
    static async delete(ctx) {
        const token = ctx.header.authorization;
        let result = await SessionService.validateToken(token);
        if (result.status === 0) {
            result = await NoticeService.removeNotice(result.data._id, ctx.params.id);
        }
        ctx.json(result);
    }
    static async update(ctx) {
        const token = ctx.header.authorization;
        let result = await SessionService.validateToken(token);
        if (result.status === 0) {
            result = await NoticeService.updateNotice(result.data._id, ctx.params.id, ctx.request.query.status);
        }
        ctx.json(result);
    }
}

module.exports = NoticeController;
