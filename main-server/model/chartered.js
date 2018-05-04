const mongoose = require('mongoose');

const Schema = mongoose.Schema;
// 包车信息
const charteredSchema = new Schema({
    // 包车订票标题
    title: {
        type: String,
        required: [true, '包车订票标题不能为空。'],
        maxlength: [20, '包车订票标题不能长于 20 个字符。'],
    },
    // 包车订票所属同乡会
    association: {
        type: Schema.Types.ObjectId,
        ref: 'Association',
        required: [true, '同乡会不能为空。'],
    },
    // 创建者
    user: {
        type: Schema.Types.ObjectId,
        ref: 'User',
    },
    // 开始报名时间
    startTime: {
        type: Date,
    },
    // 结束报名时间
    stopTime: {
        type: Date,
    },
    // 状态
    status: {
        type: Boolean,
        default: true,
    },
    // 创建时间
    createTime: {
        type: Date,
        default: Date.now,
    },
});

module.exports = mongoose.model('Chartered', charteredSchema);