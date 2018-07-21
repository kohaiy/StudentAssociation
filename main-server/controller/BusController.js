const BaseController = require('./BaseController');
const TicketService = require('../service/TicketService');
const SessionService = require('../service/SessionService');
const BusService = require('../service/BusService');

class BusController extends BaseController {

    static async get(ctx) {
        const token = ctx.header.authorization;
        let result = await SessionService.validateToken(token);
        if (result.status === 0) {
            if (ctx.request.query.cid) {
                result = await BusService.getByChartered(result.data._id, ctx.request.query.cid);
            }
        }
        ctx.json(result);
    }

    static async create(ctx) {
        const token = ctx.header.authorization;
        let result = await SessionService.validateToken(token);
        if (result.status === 0) {
            result = await BusService.create(result.data._id, ctx.request.body);
        }
        ctx.json(result);
    }

    // static async update(ctx) {
    //     const token = ctx.header.authorization;
    //     let result = await SessionService.validateToken(token);
    //     if (result.status === 0) {
    //         result = await CharteredService.update(result.data._id, ctx.request.body);
    //     }
    //     ctx.json(result);
    // }

    // static async delete(ctx) {
    //     const token = ctx.header.authorization;
    //     let result = await SessionService.validateToken(token);
    //     if (result.status === 0) {
    //         result = await TicketService.cancelTicket(result.data._id, ctx.params.id);
    //     }
    //     ctx.json(result);
    // }
}

module.exports = BusController;
