const BaseController = require('./BaseController');
const UserService = require('../service/UserService');
const SessionService = require('../service/SessionService');

class UserController extends BaseController {

    /**
     * 通过 token 获取用户信息
     * @param ctx
     * @returns {Promise<void>}
     */
    static async get(ctx) {
        const token = ctx.header.authorization;
        let result = await SessionService.validateToken(token);
        if (result.status === 0)
            result = await UserService.findById(result.data._id, ctx.request.query.logs);
        ctx.json(result);
    }

    static async getAll(ctx) {
        ctx.json(await UserService.findAll());
    }

    /**
     * 用户注册
     * @param ctx
     * @returns {Promise<void>}
     */
    static async register(ctx) {
        const { username = '', password = '' } = ctx.request.body;
        ctx.json(await UserService.register(username, password));
    }

    static async put(ctx, next) {
    }

    static async delete(ctx, next) {
    }
}

module.exports = UserController;