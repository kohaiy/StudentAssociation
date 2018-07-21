const BaseService = require('./BaseService');
const Chartered = require('../model/chartered');
const User = require('../model/user');

class CharteredService extends BaseService {

    static async getById(uid, id) {
        if (await this.isManager(uid)) {
            let chartered = await Chartered.findById(id).populate('user');
            return this.success(chartered);
        } else {
            return this.failure('用户没有权限进行该操作');
        }
    }

    static async getAll(uid) {
        const user = await User.findById(uid);
        const chartereds = await Chartered
            .find({ association: user.association })
            // .sort('-status -createTime')
            .sort('-status departureTime -createTime')
            .populate('user', 'username');
        return this.success(chartereds);
    }

    static async createChartered(uid, info = {}) {
        if (await this.isManager(uid)) {
            const user = await User.findById(uid);
            let chartered = new Chartered({
                user,
                association: user.association,
                createTime: Date.now(),
                ...info,
            });
            const error = this.validate(chartered);
            if (error) {
                return error;
            }
            chartered = await chartered.save();
            return this.success(chartered);
        } else {
            return this.failure('用户没有权限进行该操作');
        }
    }

    static async update(uid, info = {}) {
        if (await this.isManager(uid)) {
            try {
                if (!info._id) {
                    throw Error('包车信息 id 不能为空');
                }
                const user = await User.findById(uid);
                let chartered = await Chartered.findById(info._id);
                if (!chartered || !chartered.status) {
                    throw Error('该包车信息已经不存在或不可修改');
                }
                delete info._id;
                for (let key in info) {
                    chartered[key] = info[key];
                }
                const error = this.validate(chartered);
                if (error) {
                    return error;
                }
                chartered = await chartered.save();
                return this.success(chartered);
            } catch (e) {
                return this.failure(e.message);
            }
        } else {
            return this.failure('用户没有权限进行该操作');
        }
    }
}

module.exports = CharteredService;