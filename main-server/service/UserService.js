const BaseService = require('./BaseService');
const User = require('./../model/user');
const Association = require('../model/association');
const MessageService = require('./MessageService');

class UserService extends BaseService {

    /**
     * 获取用户信息
     * @param _id
     * @param opt
     * @returns {Promise<*>}
     */
    static async findById(_id = '', opt = {}) {
        if (!_id || typeof _id !== 'string' || _id.length !== 24) {
            return this.failure(' _id 不合法', 401);
        }
        let user = User.findById(_id, '-password');
        for (let key in opt) {
            if (opt[key]) {
                user = user.populate(key);
            }
        }
        user = await user;
        // 判断是否显示登录日志
        if (opt.logs) {
            user._doc.loginLogs = await this.redis().get(`LOGIN:${_id}`);
        }
        return this.success(user);
    }

    static async findPublic(_id) {
        let user = await User.findById(_id, 'username gender');
        return this.success(user);
    }

    static async findAll() {
        let users = await User.find();
        users = users.map((user) => {
            let { __v, password, ...filteredInfo } = user._doc;
            return filteredInfo;
        });
        return this.success(users);
    }

    /**
     * 注册
     * @param username
     * @param password
     * @returns {Promise<*>}
     */
    static async register(username = '', password = '') {
        let user = new User({ username, password });
        const error = this.validate(user);
        if (error) {
            return error;
        }
        if (await User.findOne({ username })) {
            return this.failure('用户名已经存在了', 400);
        }
        user = await user.save();
        return this.success(user, 201);
    }

    /**
     *
     * 更新用户密码
     * @param _id
     * @param oldPassword
     * @param newPassword
     * @returns {Promise<*>}
     */
    static async updatePassword(_id = '', oldPassword = '', newPassword = '') {
        let user = await User.findById(_id);
        console.log(user);
        if (user) {
            if (oldPassword === user.password) {
                user.password = newPassword;
                const error = this.validate(user);
                if (error) {
                    return error;
                }
                await user.save();
                return this.success();
            } else {
                return this.failure('旧密码输入错误', 400);
            }
        } else {
            return this.failure();
        }
    }

    /**
     * 更新用户信息
     * @param _id
     * @param info
     * @returns {Promise<*>}
     */
    static async updateInfo(_id = '', info = {}) {
        const { password, association, ...filtered } = info;
        let user = await User.findById(_id);
        if (user) {
            for (let key in filtered) {
                if (key === 'school' && user.association) {
                    return this.failure('当前不能修改学校，请先退出同乡会');
                }
                user[key] = filtered[key];
            }
            console.log(user);
            const error = this.validate(user);
            console.log(error);
            if (error) {
                return error;
            }
            await user.save();
            return this.success();
        } else {
            return this.failure();
        }
    }

    /**
     * 加入同乡会
     * @param userId
     * @param associationId
     * @returns {Promise<*>}
     */
    static async joinAssociation(userId, associationId) {
        const user = await User.findById(userId);
        if (user && user.school) {
            const association = await Association.findById(associationId);
            if (user.school.toString() !== association.school.toString()) {
                return this.failure('该同乡会不属于您选择的学校');
            } else {
                user.association = association;
                await user.save();
                await MessageService.createSystemMessage(
                    user,
                    association.joinMsg || '欢迎加入同乡会',
                    `加入同乡会【${association.name}】成功`)
                return this.success();
            }
        } else {
            return this.failure('请先选择学校');
        }
    }

    /**
     * 退出同乡会
     * @param userId
     * @returns {Promise<*>}
     */
    static async quitAssociation(userId) {
        const user = await User.findById(userId);
        if (user && user.association) {
            const association = await Association.findById(user.association);
            if (association.chairman.toString() === userId) {
                // 会长不能退出同乡会
                return this.failure('会长不能退出同乡会');
            }
            let index = association.managers.indexOf(userId);
            if (index > -1) {
                association.managers.splice(index, 1);
                await association.save();
            }
            user.association = null;
            await user.save();
            return this.success();
        }
        return this.failure('未知错误');
    }
}

module.exports = UserService;