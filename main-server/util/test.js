const qiniu = require('./qiniu');
qiniu('./app.js', 'app.js')
    .then(res => {
        console.log(res);
    })
    .catch(err => {
        console.log(err);
    })