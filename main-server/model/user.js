const mongoose = require('mongoose');

const Schema = mongoose.Schema;

const userSchema = new Schema({
    // 用户名：登录用，唯一，不可修改
    username: {
        type: String,
        unique: true,
        required: [true, '用户名不能为空。'],
        minlength: [3, '用户名不能短于 3 个字符。'],
        maxlength: [20, '用户名不能长于 20 个字符。'],
    },
    // 密码
    password: {
        type: String,
        required: [true, '密码不能为空。'],
        minlength: [6, '密码不能短于 6 个字符。'],
        maxlength: [20, '密码不能长于 20 个字符。'],
    },
    // 昵称：不唯一，可修改
    nickname: {
        type: String,
        minlength: [3, '昵称不能短于 3 个字符。'],
        maxlength: [20, '昵称不能长于 20 个字符。'],
    },
    // 真实姓名
    realName: {
        type: String,
        minlength: [2, '真实姓名不能短于 2 个字符。'],
        maxlength: [10, '真实姓名不能长于 10 个字符。'],
    },
    // 性别： -1 不可知， 0 男性， 1 女性
    gender: {
        type: Number,
        default: -1,
        enum: [-1, 0, 1],
    },
    // 用户所在城市
    city: {
        type: Schema.Types.ObjectId,
        ref: 'City',
    },
    // 用户所在学校
    school: {
        type: Schema.Types.ObjectId,
        ref: 'School',
    },
    // 用户所在同乡会
    association: {
        type: Schema.Types.ObjectId,
        ref: 'Association',
    },
    // 注册时间
    registerTime: {
        type: Date,
        default: Date.now(),
    },
});

module.exports = mongoose.model('User', userSchema);