const http = require('http');
const Koa = require('koa');
const app = new Koa();
const router = require('./router');
const middleware = require('./middleware');
const mongoose = require('./util/mongoose');

const config = require('./config');

mongoose(config.db.mongodb);
middleware(app);
router(app);

http.createServer(app.callback()).listen(3000, () => {
    console.log('\n'.repeat(1));
    console.log('server is running at http://localhost:3000');
});