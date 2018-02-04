const log4js = require('log4js');

module.exports = (options) => {
    return async (ctx, next) => {
        const start = Date.now();
        log4js.configure({
            appenders: {
                userRequestFileLog:
                    {type: 'file', filename: './logs/cheese.log'},
                userRequestConsoleLog:
                    {type: 'console'}

            },
            categories: {default: {appenders: ['userRequestFileLog', 'userRequestConsoleLog'], level: 'info'}}
        });
        const logger = log4js.getLogger('用户请求');
        await next();
        const end = Date.now();
        let status = ctx.response.status;
        let message = `${ctx.request.method} ${ctx.request.url} ${status} ${end - start}ms`;
        if (status >= 500) {
            logger.error(message);
        } else if (status >= 400) {
            logger.warn(message);
        } else {
            logger.info(message);
        }
    }
};