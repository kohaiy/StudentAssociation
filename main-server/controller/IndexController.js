const BaseController = require('./BaseController');

class IndexController extends BaseController {
    static async get(ctx, next) {
        ctx.json({
            status: 0,
            code: 200,
            message: ' API 服务器正常运行中...',
        });
    }
}

module.exports = IndexController;
