const router = require('koa-router')();
const IndexController = require('./controller/IndexController');
const SessionController = require('./controller/SessionController');
const UserController = require('./controller/UserController');
const AssociationController = require('./controller/AssociationController');
const UtilController = require('./controller/UtilController');

module.exports = (app) => {
    router
        .get('/', IndexController.get)
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

        .get('/associations/:school', AssociationController.getBySchool)    // 通过学校获取同乡会们
        .get('/association/:id', AssociationController.getById)             // 通过 id 获取同乡会信息
        .post('/association', AssociationController.createAssociation)      // 创建同乡会

        .get('/provinces', UtilController.getProvinces) // 获取所有省份
        .get('/cities', UtilController.getCities)       // 获取城市
        .get('/schools', UtilController.getSchools)       // 获取学校
    ;

    app.use(router.routes())
        .use(router.allowedMethods());
};
