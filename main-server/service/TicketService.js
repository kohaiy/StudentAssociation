const BaseService = require('./BaseService');
const Chartered = require('../model/chartered');
const User = require('../model/user');
const Ticket = require('../model/ticket');

class TicketService extends BaseService {
    // 获取用户的所有订票
    static async getByUser(uid) {
        let tickets = await Ticket.find({ user: uid }).populate('chartered');//.populate('bus');
        return this.success(tickets);
    }
    // 获取包车的所有订票
    static async getByChartered(uid, cid) {
        if (await this.isManager(uid)) {
            // const user = await User.findById(uid);
            let tickets = await Ticket.find({ chartered: cid }).populate('user', 'username');
            return this.success(tickets);
        } else {
            return this.failure('用户没有权限进行该操作');
        }
    }
    // 添加订票
    static async addTicket(uid, cid, { startPlace, endPlace, phone } = {}) {
        let ticket = await Ticket.findOne({ user: uid, chartered: cid });
        if (ticket) {
            return this.failure('已经登记过此次包车，不能重复登记');
        }
        let user = await User.findById(uid);
        let chartered = await Chartered.findById(cid);
        ticket = new Ticket({
            user,
            chartered,
            startPlace,
            endPlace,
            phone,
        });
        let error = this.validate(ticket);
        if (error) {
            return this.failure(error);
        }
        ticket = await ticket.save();
        return this.success(ticket);
    }

    static async cancelTicket(uid, tid) {
        let ticket = await Ticket.findOne({ user: uid, _id: tid });
        if (ticket) {
            await ticket.remove();
        }
        return this.success();
    }
}

module.exports = TicketService;