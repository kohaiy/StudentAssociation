const jwt = require('./../util/jwt');
const RedisUtil = require('./../util/redis');

class BaseService {

    static redis() {
        this.redisInstance = new RedisUtil();
        this.redis = () => {
            return this.redisInstance;
        };
        return this.redisInstance;
    }

    /**
     * 验证用户输入
     * @param instance  Model 的实例
     * @returns {*} 验证成功返回 false ， 验证失败返回错误信息
     */
    static validate(instance) {
        if (instance) {
            const error = instance.validateSync();
            if (error) {
                let errs = [];
                for (let key in error.errors) {
                    if (error.errors.hasOwnProperty(key))
                        errs.push(error.errors[key].message);
                }
                return this.failure(errs.join('\n'), 406);
            }
            return false;
        }
        return false;
    }

    /**
     * 操作成功时返回的数据
     * @param data 返回携带的数据
     * @param code 对应的 http 码
     * @param message 成功提示信息
     * @param status 状态码，默认为 0
     * @returns {{status: number, code: number, message: string, data: {}}} 返回的结果
     */
    static success(data = {}, code = 200, message = '操作成功', status = 0) {
        return {
            status,
            code,
            message,
            data,
        }
    }

    /**
     * 操作失败时返回的数据
     * @param message 失败提示信息
     * @param code 对应的 http 码
     * @param status 状态码，默认为 -1
     * @returns {{status: number, code: number, message: string}} 返回的结果
     */
    static failure(message = '操作失败', code = 500, status = -1) {
        return {
            status,
            code,
            message,
        }
    }

    /**
     * 判断用户是否为同乡会管理员或会长
     * @param {String} uid 用户 id
     */
    static async isManager(uid) {
        const manager = await User.findById(uid);
        const association = await Association.findById(manager.association);
        // 为会长 或 manager 是该同乡会管理员 并且
        if (association.chairman.toString() === uid
            || this.getIndex(association.managers, uid) > -1) {
                return true;
            }else {
                return false;
            }
    }

    static getIndex(arr = [], item = '') {
        if (arr instanceof Array) {
            return arr.map(val => val && val.toString()).indexOf(item.toString());
        }
        return -1;
    }

    static random(type = Number, length = 4) {
        let randomChar = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
        let res = [];
        for (let i = 0; i < length; i++) {
            res.push(randomChar[Math.round(Math.random() * (randomChar.length - 1))]);
        }
        return res.join('');
    }

}

module.exports = BaseService;
