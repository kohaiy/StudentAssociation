const mongoose = require('mongoose');

const Schema = mongoose.Schema;

const messageSchema = new Schema({
    title: {
        type: String,
        maxlength: [50, '消息标题不能长于 50 个字符'],
    },
    content: {
        type: String,
        maxlength: [1000, '消息内容不能长于 1000 个字符'],
    },
    sender: {
        type: Schema.Types.ObjectId,
        ref: 'User',
        default: null,
    },
    receiver: {
        type: Schema.Types.ObjectId,
        ref: 'User',
        required: true,
    },
    createTime: {
        type: Date,
        default: Date.now(),
    },
    status: {
        type: Boolean,
        default: false,
    },
});

module.exports = mongoose.model('Message', messageSchema);