const path = require('path');

module.exports = (opts = {}) => {
    // 增加环境变量，用来传入到视图中，方便调试
    const env = opts.env || process.env.NODE_ENV || 'development';

    return async (ctx, next) => {
        try {
            await next();
            if (ctx.response.status === 404 && !ctx.response.body)
                ctx.throw(404);
        } catch (e) {
            ctx.status = e.status || 500;
            const result = {
                status: -1,
                code: ctx.status,
                message: '服务器出了点小问题，请稍候再试！',
            };
            if (env === 'development') {
                result.data = {
                    error: e.message,
                    stack: e.stack,
                };
            }
            ctx.json(result);
        }
    };
};