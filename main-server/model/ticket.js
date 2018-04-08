const mongoose = require('mongoose');

const Schema = mongoose.Schema;
// 包车订票信息
const ticketSchema = new Schema({
    // 登记成员情况
    user: {
        type: Schema.Types.ObjectId,
        ref: 'User',
        required: [true, '成员信息不能为空。'],
    },
    phone: {
        type: String,
        required: [true, '登记成员联系方式不能为空。']
    },
    quantity: {
        type: Number,
        min: [1, '选取票数不能少于 1 张。'],
        default: 1,
    },
    // 上车地点
    startPlace: {
        type: [String],
        required: [true, '出发地不能为空。'],
    },
    // 下车地点
    endPlace: {
        type: [String],
        required: [true, '目的地不能为空。'],
    },
    // 创建时间
    createTime: {
        type: Date,
        default: Date.now,
    },
});

module.exports = mongoose.model('Ticket', ticketSchema);