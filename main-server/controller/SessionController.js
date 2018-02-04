const BaseController = require('./BaseController');
const SessionService = require('../service/SessionService');

class SessionController extends BaseController {
    static async get(ctx, next) {
        await SessionService.test();
        ctx.session.views = ctx.session.views || 0;
        const data = {
            type: 'get',
            views: ctx.session.views++,
        };
        ctx.json(data);
    }

    /**
     * 登录功能
     * @param ctx
     * @returns {Promise<void>}
     */
    static async login(ctx) {
        const { username = '', password = '' } = ctx.request.body;
        const result = await SessionService.login(username, password);
        ctx.json(result);
    }

    static async put(ctx, next) {
        ctx.body = 'put';
    }

    static async delete(ctx, next) {
        ctx.body = 'delete';
    }
}

module.exports = SessionController;
