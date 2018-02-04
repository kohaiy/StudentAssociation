const mongoose = require('mongoose');

module.exports = ({ uri = 'mongodb://localhost/' } = {}) => {
    mongoose.connect(uri);
    mongoose.connection.on("connected", function () {
        console.log("MongoDB connected success.")
    });

    mongoose.connection.on("error", function () {
        console.log("MongoDB connected fail.")
    });

    mongoose.connection.on("disconnected", function () {
        console.log("MongoDB connected disconnected.")
    });
};