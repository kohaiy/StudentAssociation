const jwt = require('jsonwebtoken');
const config = require('./../config');

module.exports = {
    sign(payload = {}) {
        return jwt.sign(payload, config.token.privateKey);
    },
    verify(token = '') {
        return jwt.verify(token, config.token.privateKey);
    },
};