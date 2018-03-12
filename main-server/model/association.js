const mongoose = require('mongoose');

const Schema = mongoose.Schema;

const associationSchema = new Schema({
    // 同乡会名称
    name: {
        type: String,
        required: true,
        minlength: [3, '同乡会名称不能短于 3 个字符'],
        maxlength: [20, '同乡会名称不能长于 20 个字符'],
    },
    // 描述信息
    description: {
        type: String,
        maxlength: [200, '同乡会描述不能长于 200 个字符'],
    },
    // 新成员加入时欢迎词
    joinMsg: {
        type: String,
        default: '欢迎加入',
        maxlength: [50, '同乡会欢迎词不能长于 50 个字符'],
    },
    // 创建时间
    createTime: {
        type: Date,
        default: Date.now(),
    },
    // 同乡会状态
    status: {
        type: Boolean,
        default: true,
    },
    // 同乡会所在学校
    school: {
        type: Schema.Types.ObjectId,
        ref: 'School',
        required: true,
    },
    // 同乡会成员地区
    city: {
        type: Schema.Types.ObjectId,
        ref: 'City',
        required: true,
    },
    // 会长
    chairman: {
        type: Schema.Types.ObjectId,
        ref: 'User',
        required: true,
    },
    // 管理员们
    managers: [{
        type: Schema.Types.ObjectId,
        ref: 'User',
    }],
});

module.exports = mongoose.model('Association', associationSchema);