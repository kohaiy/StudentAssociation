const mongoose = require('mongoose');

const Schema = mongoose.Schema;

const associationSchema = new Schema({
    school: {
        type: Schema.Types.ObjectId,
        ref: 'School',
    },
});

module.exports = mongoose.model('Association', associationSchema);