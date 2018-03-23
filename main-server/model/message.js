const mongoose = require('mongoose');

const Schema = mongoose.Schema;

const messageSchema = new Schema({
    // 标题
    title: {
        type: String,
        maxlength: [50, '消息标题不能长于 50 个字符'],
    },
    // 内容
    content: {
        type: String,
        maxlength: [1000, '消息内容不能长于 1000 个字符'],
    },
    // 发送者，系统消息为 null
    sender: {
        type: Schema.Types.ObjectId,
        ref: 'User',
        default: null,
    },
    // 接收者
    receiver: {
        type: Schema.Types.ObjectId,
        ref: 'User',
        required: true,
    },
    // 创建时间
    createTime: {
        type: Date,
        default: Date.now(),
    },
    // 状态：已读 或 未读
    status: {
        type: Boolean,
        default: false,
    },
});

module.exports = mongoose.model('Message', messageSchema);