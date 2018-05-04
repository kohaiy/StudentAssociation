const mongoose = require('mongoose');

const Schema = mongoose.Schema;
// 包车车辆信息
const BusSchema = new Schema({
    // 所属的包车
    chartered: {
        type: Schema.Types.ObjectId,
        ref: 'Chartered',
    },
    // 车辆车牌
    plateNumber: {
        type: String,
        default: '暂无车牌信息',
    },
    // 车票单价
    price: {
        type: Number,
        default: 0,
        required: [true, '车票单价不能为空。'],
    },
    // 最大座位数
    maxSeat: {
        type: Number,
        default: -1,
        required: [true, '最大座位数不能为空。'],
    },
    // 上车地点
    startPlace: {
        type: [String],
        required: [true, '上车地点不能为空。'],
    },
    // 下车地点
    endPlace: {
        type: [String],
        required: [true, '下车地点不能为空。'],
    },
});

module.exports = mongoose.model('Bus', BusSchema);