const BaseService = require('./BaseService');
const Association = require('../model/association');
const User = require('../model/user');

class AssociationService extends BaseService {

    /**
     * 通过学校获取同乡会们
     * @param schoolId
     * @returns {Promise<{status: number, code: number, message: string, data: {}}>}
     */
    static async getAssociationsBySchoolId(schoolId) {
        let associations = await Association.find({ school: schoolId });
        return this.success(associations);
    }

    /**
     * 获取同乡会信息
     * @param _id
     * @param opts
     * @returns {Promise<{status: number, code: number, message: string, data: {}}>}
     */
    static async getById(_id, opts) {
        const user = await User.findById(_id);
        let association = Association.findById(user.association);
        for (let key in opts) {
            if (key !== 'chairman' && key !== 'managers') {
                association = association.populate(key);
            } else {
                association = association.populate({
                    path: key,
                    select: '-password -realName',
                });
            }
        }
        association = await association;
        return this.success(association);
    }

    /**
     * 创建同乡会
     * @param uid 创建者
     * @param name 同乡会名称
     * @param city 所属城市
     * @param description 同乡会描述
     * @returns {Promise<*>}
     */
    static async createAssociation(uid, name, city, description) {
        const user = await User.findById(uid);
        if (!user.school || user.association) {
            return this.failure('出现未知错误');
        }
        let association = new Association({
            name,
            city,
            description,
            chairman: user._id,
            school: user.school,
        });
        const error = this.validate(association);
        if (error) {
            return error;
        }
        association = await association.save();
        user.association = association._id;
        await user.save();
        return this.success(association);
    }

    /**
     * 获取同乡会的所有成员
     * @param uid
     * @returns {Promise<{status: number, code: number, message: string, data: {}}>}
     */
    static async getMembersByAid(uid) {
        const user = await User.findById(uid);
        const members = await User.find({ association: user.association }, '-password');
        const filtered = members.map((member) => {
            let { _id, username, nickname, gender, openEmail, openPhoneNumber, email, phoneNumber } = member._doc;
            const temp = { _id, username, nickname, gender };
            temp.email = openEmail ? email : email && email.slice(0, 2) + '***';
            temp.phoneNumber = openPhoneNumber ? phoneNumber : phoneNumber && phoneNumber.slice(0, 2) + '***';
            return temp;
        });
        return this.success(filtered);
    }

    /**
     * 设置成员为管理员
     * @param chairmanId 会长 id
     * @param memberId 成员 id
     * @returns {Promise<{status: number, code: number, message: string, data: {}}>}
     */
    static async setMemberToManager(chairmanId, memberId) {
        const chairman = await User.findById(chairmanId);
        const member = await User.findById(memberId);
        const association = await Association.findById(chairman.association);
        // 判断会长是否真的是会长 并且 判断会员所在同乡会是否与会长一样
        if (association._id.toString() === member.association.toString()
            && association.chairman.toString() === chairmanId) {
            association.managers.push(memberId);
            await association.save();
            return this.success();
        } else {
            return this.failure('权限问题');
        }
    }

    /**
     * 设置管理员为成员
     * @param chairmanId
     * @param memberId
     * @returns {Promise<*>}
     */
    static async setManagerToMember(chairmanId, memberId) {
        const chairman = await User.findById(chairmanId);
        const member = await User.findById(memberId);
        const association = await Association.findById(chairman.association);
        // 判断会长是否真的是会长 并且 判断会员所在同乡会是否与会长一样
        if (association._id.toString() === member.association.toString()
            && association.chairman.toString() === chairmanId) {
            association.managers.splice(this.getIndex(association.managers, memberId), 1);
            await association.save();
            return this.success();
        } else {
            return this.failure('权限不足');
        }
    }

    /**
     * 重设会长
     * @param chairmanId
     * @param memberId
     * @returns {Promise<*>}
     */
    static async resetChairman(chairmanId, memberId) {
        const chairman = await User.findById(chairmanId);
        const member = await User.findById(memberId);
        const association = await Association.findById(chairman.association);
        // 判断会长是否真的是会长 并且 判断会员所在同乡会是否与会长一样
        if (association._id.toString() === member.association.toString()
            && association.chairman.toString() === chairmanId) {
            association.chairman = member;
            await association.save();
            return this.success();
        } else {
            return this.failure('权限不足');
        }
    }

    /**
     * 踢除会员
     * @param managerId
     * @param memberId
     * @returns {Promise<*>}
     */
    static async setMemberOut(managerId, memberId) {
        // console.log(managerId);
        // console.log(memberId);
        const manager = await User.findById(managerId);
        const member = await User.findById(memberId);
        const association = await Association.findById(manager.association);
        // 为会长 或 manager 是该同乡会管理员 并且 member 与 manager 同一同乡会
        if (association.chairman.toString() === managerId
            || this.getIndex(association.managers, managerId) > -1
            && member.association.toString() === association._id.toString()) {
            // 踢除的会员是管理员
            let index = this.getIndex(association.managers, memberId);
            if (index > -1) {
                association.managers.splice(index, 1);
                await association.save();
            }
            member.association = null;
            await member.save();
            return this.success();
        } else {
            return this.failure('权限不足');
        }
    }

    static async updateInfo(uid, info) {
        // 判断是否为 会长 或 管理员
        const { error, user } = await this.isChairmanOrManager(uid);
        if (error) {
            return error;
        }
        let association = await Association.findById(user.association._id);
        for (let key in info) {
            if (info.hasOwnProperty(key) && key !== 'address') {
                association[key] = info[key];
            }
        }
        // association.name = name;
        // association.description = description || association.description;
        // association.joinMsg = joinMsg || association.joinMsg;
        if (info.hasOwnProperty('address')) {
            association.addresses.unshift(info.address);
        }
        if (info.hasOwnProperty('-address')) {
            association.addresses.splice(association.addresses.indexOf(info['-address']), 1);
        }
        const errors = this.validate(association);
        if (errors) {
            return errors;
        }
        association = await association.save();
        return this.success(association);
    }

    /**
     * 判断用户是否为同乡会会长或管理员
     * @param {String} uid user id
     * @returns {user | error} true时返回user，false时返回error
     */
    static async isChairmanOrManager(uid) {
        const user = await User.findById(uid).populate('association');
        if (user.association.chairman.toString() === uid
            || this.getIndex(user.association.managers, uid) > -1) {
            return {
                user,
            };
        } else {
            return {
                error: this.failure('权限不足：只有会长和管理员有权限执行此操作'),
            };
        }
    }
}

module.exports = AssociationService;
