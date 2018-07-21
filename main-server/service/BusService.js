const BaseService = require('./BaseService');
const Chartered = require('../model/chartered');
const User = require('../model/user');
const Ticket = require('../model/ticket');
const Bus = require('../model/bus');

class BusService extends BaseService {
    static async getByChartered(uid, cid) {
        if (await this.isManager(uid)) {
            let buses = await Bus.find({ chartered: cid });
            for (let i = 0; i < buses.length; i++) {
                buses[i]['tickets'] = await Ticket.find({ bus: buses[i] });
            }
            return this.success(buses);
        } else {
            return this.failure('没有权限的操作');
        }
    }
    static async create(uid, { cid, title, tickets = [], startPlace, endPlace } = {}) {
        if (await this.isManager(uid)) {
            let bus = new Bus({
                title,
                chartered: cid,
                startPlace,
                endPlace,
            });
            let err = this.validate(bus);
            if (err) {
                return this.failure(err);
            }
            bus = await bus.save();
            for (let i = 0; i < tickets.length; i++) {
                await Ticket.findOneAndUpdate({ _id: tickets[i] }, { $set: { bus } });
            }
            return this.success(bus);
        } else {
            return this.failure('没有权限的操作');
        }
    }
}

module.exports = BusService;