/**
 * 云通信基础能力业务短信发送、查询详情以及消费消息示例，供参考。
 * Created on 2017-07-31
 */
const SMSClient = require('@alicloud/sms-sdk');
const { accessKeyId, secretAccessKey } = require('../config/alisms');
//初始化sms_client
let smsClient = new SMSClient({ accessKeyId, secretAccessKey });
module.exports = {
    sendSMS(phoneNumbers, code) {
        return new Promise((resolve, reject) => {
            //发送短信
            smsClient.sendSMS({
                PhoneNumbers: phoneNumbers,
                SignName: '柯灰同乡网',
                TemplateCode: 'SMS_133875191',
                TemplateParam: `{"code":"${code}"}`,
            }).then(function (res) {
                let { Code } = res
                if (Code === 'OK') {
                    //处理返回参数
                    resolve({ res });
                } else {
                    reject({ err: res });
                }
            }, function (err) {
                reject({ err });
            })
        });
    },
}
