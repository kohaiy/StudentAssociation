const mongoose = require('mongoose');

const Schema = mongoose.Schema;
// 学校
const schoolSchema = new Schema({
    sid: {
        type: String,
    },
    cid: {
        type: Schema.Types.ObjectId,
        ref: 'City',
    },
    name: {
        type: String,
    },
});

module.exports = mongoose.model('School', schoolSchema);