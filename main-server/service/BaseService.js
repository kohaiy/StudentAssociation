const jwt = require('./../util/jwt');

class BaseService {

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
}

module.exports = BaseService;