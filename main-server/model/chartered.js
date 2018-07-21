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
    // 包车信息描述
    description: {
        type: String,
        maxlength: [200, '包车信息描述长度不能超过 200 个字符'],
    },
    // 车票单价
    price: {
        type: Number,
        default: 0,
        required: [true, '车票单价不能为空。'],
    },
    // 发车时间
    departureTime: {
        type: Date,
        required: [true, '发车时间不能为空'],
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
    // 人数上限
    limit: {
        type: Number,
        default: -1,
        required: [true, '人数上限不能为空。'],
    },
    // 报名时间：[开始时间, 结束时间]
    checkInTime: {
        type: [Date],
        // required: [true, '报名时间不能为空。'],
        validate: {
            validator: function (v) {
                return Array.isArray(v) && v.length >= 2;
            },
            message: '报名时间不能为空。'
        },
    },
    // 上车地点
    startPlaces: {
        type: [String],
        validate: {
            validator: function (v) {
                return Array.isArray(v) && v.length > 0;
            },
            message: '上车地点不能为空。'
        },
        // , '上车地点不能为空。'],
    },
    // 下车地点
    endPlaces: {
        type: [String],
        validate: {
            validator: function (v) {
                return Array.isArray(v) && v.length > 0;
            },
            message: '下车地点不能为空。'
        },
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