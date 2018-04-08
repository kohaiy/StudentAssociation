const path = require('path');
const qiniu = require('qiniu');
const qiniuConfig = require('../config/qiniu');
const Redis = require('./redis');
const redis = new Redis();
const __root = path.join(__dirname, '../');

module.exports = async (localFile, key) => {
    localFile = path.join(__root, localFile);
    let uploadToken = await redis.get('qiniuToken');
    if (!uploadToken) {
        const mac = new qiniu.auth.digest.Mac(qiniuConfig.accessKey, qiniuConfig.secretKey);
        const options = {
            scope: qiniuConfig.bucket,
            expires: qiniuConfig.expires
        };
        const putPolicy = new qiniu.rs.PutPolicy(options);
        uploadToken = putPolicy.uploadToken(mac);
        redis.set('qiniuToken', uploadToken, qiniuConfig.expires);
    }
    console.log(uploadToken);
    const config = new qiniu.conf.Config();
    // 空间对应的机房
    config.zone = qiniu.zone.Zone_z2;
    const formUploader = new qiniu.form_up.FormUploader(config);
    const putExtra = new qiniu.form_up.PutExtra();
    key = qiniuConfig.prefix + key;
    return new Promise((resolve, reject) => {
        // resolve();
        // 文件上传
        formUploader.putFile(uploadToken, key, localFile, putExtra, function (respErr,
            respBody, respInfo) {
            resolve({ respErr, respBody, respInfo });
        });
    });
};