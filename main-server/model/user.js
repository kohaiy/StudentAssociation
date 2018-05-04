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
    // 邮箱地址
    email: {
        type: String,
        validate: {
            validator: function (v) {
                return /^([0-9A-Za-z\-_\.]+)@([0-9a-z]+\.[a-z]{2,3}(\.[a-z]{2})?)$/g.test(v);
            },
            message: '邮箱地址格式不正确。'
        },
    },
    // 是否公开邮箱
    openEmail: {
        type: Boolean,
        default: true,
    },
    // 手机号码
    phoneNumber: {
        type: String,
        validate: {
            validator: function (v) {
                return /^(([0-9]{6})|([0-9]{11}))$/g.test(v);
            },
            message: '手机号码格式不正确。'
        },
    },
    // 是否公开手机号码
    openPhoneNumber: {
        type: Boolean,
        default: false,
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
    // 头像
    avatar: {
        type: String,
        default: null,
    },
});

module.exports = mongoose.model('User', userSchema);