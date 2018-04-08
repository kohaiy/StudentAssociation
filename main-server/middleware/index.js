const path = require('path');
const bodyParser = require('koa-bodyparser');
const session = require('koa-session2');
const cors = require('koa2-cors');
const staticFiles = require('koa-static');

const Store = require('./../util/redis-store');
const log = require('./log');
const json = require('./json');
const httpError = require('./http-error');

const config = require('./../config');

module.exports = (app) => {

    // 配置跨域请求
    app.use(cors({
        origin(ctx) {
            const domain = [
                'http://localhost:80801',
                'http://localhost:8080',
            ];
            if (domain.indexOf(ctx.header.origin) > -1) {
                return ctx.header.origin;
            } else {
                return false;
            }
        },
    }));

    // 配置 session
    app.use(session({
        store: new Store(config.db.redis),
        maxAge: 2 * 60 * 60 * 1000,
        key: 'SESSION_ID',
    }));

    // 配置日志输出
    app.use(log());

    // 指定 public目录为静态资源目录，用来存放 js css images 等
    app.use(staticFiles(path.resolve(__dirname, "../public")));

    // 配置 json 数据返回
    app.use(json());

    // 配置错误页
    app.use(httpError({
        env: 'development',
    }));

    // 配置表单提交
    app.use(bodyParser());

    app.on("error", (err, ctx) => {
        console.log(err);
        if (ctx && !ctx.headerSent && ctx.status < 500) {
            ctx.status = 500;
        }
        if (ctx && ctx.log && ctx.log.error) {
            if (!ctx.state.logged) {
                ctx.log.error(err.stack);
            }
        }
    });
};