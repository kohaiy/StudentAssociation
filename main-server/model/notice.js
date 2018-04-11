const mongoose = require('mongoose');

const Schema = mongoose.Schema;
// 公告信息
const noticeSchema = new Schema({
    // 公告内容
    content: {
        type: String,
        maxlength: [200, '公告内容不能长于 200 个字符。'],
    },
    // 公告图片
    images: {
        type: [String],
    },
    // 创建者
    user: {
        type: Schema.Types.ObjectId,
        ref: 'User',
    },
    // 所属同乡会
    association: {
        type: Schema.Types.ObjectId,
        ref: 'Association',
    },
    // 状态： true 为显示， false 为不显示
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

module.exports = mongoose.model('Notice', noticeSchema);