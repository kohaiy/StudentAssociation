const mongoose = require('mongoose');

const Schema = mongoose.Schema;
// 包车车辆信息
const BusSchema = new Schema({
    title: {
        type: String,
        default: '起个名字这么难',
    },
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
    // 上车地点
    startPlace: {
        type: String,
        required: [true, '上车地点不能为空。'],
    },
    // 下车地点
    endPlace: {
        type: String,
        required: [true, '下车地点不能为空。'],
    },
});

module.exports = mongoose.model('Bus', BusSchema);