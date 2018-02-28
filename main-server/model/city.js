const mongoose = require('mongoose');

const Schema = mongoose.Schema;
// 城市
const citySchema = new Schema({
    cid: {
        type: String,
    },
    pid: {
        type: Schema.Types.ObjectId,
        ref: 'Province',
    },
    name: {
        type: String,
    },
});

module.exports = mongoose.model('City', citySchema);