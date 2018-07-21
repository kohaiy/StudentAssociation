const router = require('koa-router')();
const multer = require('koa-multer');
// const images = require('images');
const IndexController = require('./controller/IndexController');
const SessionController = require('./controller/SessionController');
const UserController = require('./controller/UserController');
const AssociationController = require('./controller/AssociationController');
const MessageController = require('./controller/MessageController');
const NoticeController = require('./controller/NoticeController');
const CharteredController = require('./controller/CharteredController');
const TicketController = require('./controller/TicketController');
const BusController = require('./controller/BusController');
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
        .get('/user/:id', UserController.getPublicUser)
        .get('/users', UserController.getAll)           // 获取所有用户
        .get('/user', UserController.get)               // 获取用户信息
        .post('/user', UserController.register)         // 注册
        .put('/user', UserController.put)               // 更新用户信息
        .delete('/user', UserController.delete)         // 注销用户

        .get('/associations/:school', AssociationController.getBySchool)    // 通过学校获取同乡会们
        .get('/association', AssociationController.getById)                 // 通过 id 获取同乡会信息
        .post('/association', AssociationController.createAssociation)      // 创建同乡会
        .get('/association/members', AssociationController.getMembers)      // 获取同乡会成员
        .put('/association', AssociationController.update)                  // 更新

        .get('/chartered', CharteredController.get)          // 获取包车信息
        .get('/chartereds', CharteredController.getAll)          // 获取包车信息
        .post('/chartered', CharteredController.create)         // 发布包车信息
        .put('/chartered', CharteredController.update)         // 更改包车信息

        .get('/ticket', TicketController.get)
        .post('/ticket', TicketController.create)
        .delete('/ticket/:id', TicketController.delete)

        .get('/bus',BusController.get)
        .post('/bus',BusController.create)

        .get('/messages', MessageController.get)            // 获取消息
        .get('/message/list', MessageController.getMemberList)
        // .get('/message/:id', MessageController.getMessagesBy)
        .post('/message', MessageController.create)         // 创建消息
        .post('/messages', MessageController.massMessage)   // 群发消息
        // .put('/message', MessageController.read)            // 设置消息为已读
        // .delete('/message/:id', MessageController.remove)       // 删除一条消息
        // .delete('/messages', MessageController.removeAll)   // 删除全部消息

        .get('/notices', NoticeController.get)              // 获取所有公告
        .post('/notice', NoticeController.create)           // 创建公告
        .put('/notice/:id', NoticeController.update)        // 更新公告
        .delete('/notice/:id', NoticeController.delete)     // 删除公告

        .get('/provinces', UtilController.getProvinces)     // 获取所有省份
        .get('/cities', UtilController.getCities)           // 获取城市
        .get('/schools', UtilController.getSchools)         // 获取学校
        .get('/geetest', UtilController.geetestGet)            // 极验
        .post('/geetest', UtilController.geetestPost)            // 极验
        .get('/sms', UtilController.sms)
        ;

    // 配置
    const storage = multer.diskStorage({
        //文件保存路径
        destination: function (req, file, cb) {
            cb(null, 'public/uploads')
        },
        //修改文件名称
        filename: function (req, file, cb) {
            let fileFormat = (file.originalname).split(".");
            cb(null, Date.now() + "." + fileFormat[fileFormat.length - 1]);
        },
    });
    // 加载配置
    const upload = multer({ storage: storage });
    // 路由
    router.post('/upload', upload.single('file'), UtilController.upload);

    app.use(router.routes())
        .use(router.allowedMethods());
};
