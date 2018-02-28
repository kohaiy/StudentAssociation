const Redis = require('ioredis');
const BaseService = require('./BaseService');
const User = require('./../model/user');
const jwt = require('./../util/jwt');
const config = require('./../config');

class SessionService extends BaseService {

    /**
     * 登录 业务
     * @param username
     * @param password
     * @returns {Promise<*>}
     */
    static async login(username, password) {
        let user = new User({ username, password });
        // 验证用户输入是否合法
        const error = this.validate(user);
        if (error) {
            return error;
        }
        user = await User.findOne({ username });
        if (!user) {
            return this.failure('用户不存在');
        } else if (user.password !== password) {
            return this.failure('密码不正确');
        } else {
            // user.userTime.lastLogin = Date.now();
            // await user.save();
            // 登录成功，创建 token
            const token = jwt.sign({ _id: user._id });
            // 将 token 保存到 redis 中
            await this.redis().set(`TOKEN:${user._id}`, token);
            // 获取登录记录
            let loginLogs = await this.redis().get(`LOGIN:${user._id}`) || [];
            // 过滤掉过早的登录记录
            loginLogs = loginLogs.filter((time) => {
                return Date.now() - time < config.loginLogsMaxAge * 1000;
            });
            // 添加本次登录记录
            loginLogs.unshift(Date.now());
            await this.redis().set(`LOGIN:${user._id}`, loginLogs, -1);
            // 返回 _id 和 token
            return this.success({
                _id: user._id,
                token,
            });
        }
    }

    static async validateToken(token) {
        try {
            const { _id = '' } = jwt.verify(token);
            if (!await this.redis().get(`TOKEN:${_id}`)) {
                return this.failure('令牌验证失败！', 401);
            }
            await this.redis().set(`TOKEN:${_id}`, token);
            return this.success({
                _id,
                token,
            });
        } catch (e) {
            return this.failure('令牌验证失败！', 401);
        }
    }
}

module.exports = SessionService;