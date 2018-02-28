const mongoose = require('mongoose');

const Schema = mongoose.Schema;
// 省份
const provinceSchema = new Schema({
    pid: {
        type: String,
    },
    name: {
        type: String,
    },
});

module.exports = mongoose.model('Province', provinceSchema);