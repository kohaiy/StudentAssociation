module.exports = {
    db: {
        mongodb: {
            uri: 'mongodb://localhost/sa-main',
        },
        redis: {
            host: 'localhost',
            port: 6379,
            db: 5,
            options: {
                return_buffers: false,
                auth_pass: '',
            },
        },
    },
    token: {
        privateKey: 'kohai',
        expireTime: 2 * 60 * 60,    // token 2 小时失效
    },
    loginLogsMaxAge: 30 * 24 * 60 * 60, // 登录记录最长保留时间（s）
    isQiniu: false,
};