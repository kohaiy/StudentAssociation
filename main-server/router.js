const router = require('koa-router')();
const IndexController = require('./controller/IndexController');
const SessionController = require('./controller/SessionController');
const UserController = require('./controller/UserController');

module.exports = (app) => {
    router.get('/', IndexController.get)
        // Session
        .get('/session', SessionController.get)         // 获取会话信息
        .post('/session', SessionController.login)      // 登录
        .put('/session', SessionController.put)         // 更新会话信息
        .delete('/session', SessionController.delete)   // 注销登录
        // User
        .get('/users', UserController.getAll)           // 获取所有用户
        .get('/user', UserController.get)               // 获取用户信息
        .post('/user', UserController.register)         // 注册
        .put('/user', UserController.put)               // 更新用户信息
        .delete('/user', UserController.delete)         // 注销用户
    ;

    app.use(router.routes())
        .use(router.allowedMethods());
};
