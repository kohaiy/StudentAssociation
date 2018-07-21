const BaseController = require('./BaseController');
const CharteredService = require('../service/CharteredService');
const SessionService = require('../service/SessionService');

class CharteredController extends BaseController {

    static async get(ctx) {
        const token = ctx.header.authorization;
        let result = await SessionService.validateToken(token);
        if (result.status === 0) {
            result = await CharteredService.getById(result.data._id, ctx.request.query.id);
        }
        ctx.json(result);
    }

    static async getAll(ctx) {
        const token = ctx.header.authorization;
        let result = await SessionService.validateToken(token);
        if (result.status === 0) {
            result = await CharteredService.getAll(result.data._id);
        }
        ctx.json(result);
    }

    static async create(ctx) {
        const token = ctx.header.authorization;
        let result = await SessionService.validateToken(token);
        if (result.status === 0) {
            result = await CharteredService.createChartered(result.data._id, ctx.request.body);
        }
        ctx.json(result);
    }

    static async update(ctx) {
        const token = ctx.header.authorization;
        let result = await SessionService.validateToken(token);
        if (result.status === 0) {
            result = await CharteredService.update(result.data._id, ctx.request.body);
        }
        ctx.json(result);
    }
}

module.exports = CharteredController;
