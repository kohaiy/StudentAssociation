const BaseController = require('./BaseController');
const IndexService = require('../service/IndexService');

class IndexController extends BaseController {
    static async get(ctx, next) {
        ctx.json({
            status: 0,
            code: 200,
            message: ' API 服务器正常运行中...',
        });
        // 初始化学校数据，执行一次就好
        // await IndexService.initSchools();
    }
}

module.exports = IndexController;
