const BaseController = require('./BaseController');
const IndexService = require('../service/IndexService');
const Association = require('../model/association');

class IndexController extends BaseController {
    static async get(ctx, next) {
        ctx.json({
            status: 0,
            code: 200,
            message: ' API 服务器正常运行中...',
        });
        // let as = new Association({
        //    name: 'ceshi'
        // });
        // await as.save();
        // 初始化学校数据，执行一次就好
        // await IndexService.initSchools();
    }
}

module.exports = IndexController;
