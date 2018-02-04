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
};