const BaseController = require('./BaseController');
const MessageService = require('../service/MessageService');
const SessionService = require('../service/SessionService');

class MessageController extends BaseController {

    static async get(ctx) {
        const token = ctx.header.authorization;
        let result = await SessionService.validateToken(token);
        if (result.status === 0) {
            if (ctx.request.query.whisper) {
                // get whisper messages
                result = await MessageService
                    .getWhisperMessages(result.data._id, ctx.request.query.whisper, ctx.request.query);
            } else if (ctx.request.query.unread) {
                // 获取未读消息数量
                result = await MessageService.getUnreadMessagesQuantity(result.data._id);
            } else {
                // get system messages
                result = await MessageService.getSystemMessages(result.data._id, ctx.request.query);
            }
        }
        ctx.json(result);
    }

    static async getMemberList(ctx) {
        const token = ctx.header.authorization;
        let result = await SessionService.validateToken(token);
        if (result.status === 0) {
            result = await MessageService.getMemberList(result.data._id);
        }
        ctx.json(result);
    }

    static async create(ctx) {
        const token = ctx.header.authorization;
        let result = await SessionService.validateToken(token);
        if (result.status === 0) {
            const {receiver, content} = ctx.request.body;
            result = await MessageService.createWhisperMessage(receiver, content, result.data._id);
        }
        ctx.json(result);
    }

    static async massMessage(ctx) {
        const token = ctx.header.authorization;
        let result = await SessionService.validateToken(token);
        if (result.status === 0) {
            result = await MessageService.massMessage(result.data._id, ctx.request.body.content);
        }
        ctx.json(result);
    }
}

module.exports = MessageController;
