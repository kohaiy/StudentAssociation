const BaseService = require('./BaseService');
const User = require('./../model/user');

class UserService extends BaseService {

    /**
     * 通过 id 获取用户信息
     * @param _id
     * @param isShowLogs 是否显示登录日志
     * @returns {Promise<*>}
     */
    static async findById(_id = '', isShowLogs) {
        if (!_id || typeof _id !== 'string' || _id.length !== 24) {
            return this.failure(' _id 不合法', 401);
        }
        const user = await User.findById(_id);
        // 过滤掉用户密码和相关不必要信息
        let { __v, password, ...filteredInfo } = user._doc;
        // 判断是否显示登录日志
        if (isShowLogs) {
            filteredInfo.loginLogs = await this.redis().get(`LOGIN:${_id}`);
        }
        return this.success(filteredInfo);
    }

    static async findAll() {
        let users = await User.find();
        users = users.map((user) => {
            let { __v, password, ...filteredInfo } = user._doc;
            return filteredInfo;
        });
        return this.success(users);
    }

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
}

module.exports = UserService;