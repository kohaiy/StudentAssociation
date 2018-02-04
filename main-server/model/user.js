const mongoose = require('mongoose');

const Schema = mongoose.Schema;

const userSchema = new Schema({
    username: {
        type: String,
        unique: true,
        required: [true, '用户名必须嘚！'],
        minlength: [3, '用户名为3-20字符。'],
        maxlength: [20, '用户名为3-20字符。'],
    },
    password: {
        type: String,
        required: [true, '密码必须嘚！'],
        minlength: [6, '你确定你只有这么短！'],
        maxlength: [20, '你确定你有这么长！'],
    },
    gender: {
        type: Number,
        default: -1,
        enum: [-1, 0, 1],
    },
    userTime: {
        register: {
            type: Date,
            default: Date.now(),
        },
        lastLogin: {
            type: Date,
            default: Date.now(),
        },
    },
});

module.exports = mongoose.model('User', userSchema);