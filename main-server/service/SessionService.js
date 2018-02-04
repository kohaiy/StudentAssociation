const Redis = require('ioredis');
const BaseService = require('./BaseService');
const Session = require('./../model/session');
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
            // 登录成功，创建 token
            const token = jwt.sign({ _id: user._id });
            // 实例化 redis ，如果已经实例过就直接用
            this.redis = this.redis || new Redis(config.db.redis);
            // 将 token 保存到 redis 中，并设置过期时间
            await this.redis.set(`TOKEN:${user._id}`, token, 'EX', config.token.expireTime);
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
            this.redis = this.redis || new Redis(config.db.redis);
            if (!await this.redis.get(`TOKEN:${_id}`)) {
                return this.failure('令牌验证失败！', 401);
            }
            await this.redis.set(`TOKEN:${_id}`, token, 'EX', config.token.expireTime);
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