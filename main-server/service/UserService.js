const BaseService = require('./BaseService');
const User = require('./../model/user');

class UserService extends BaseService {

    static async findById(_id = '') {
        if (!_id || typeof _id !== 'string' || _id.length !== 24) {
            return this.failure(' _id 不合法', 401);
        }
        const user = await User.findById(_id);
        let { __v, password, ...filteredInfo } = user._doc;
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