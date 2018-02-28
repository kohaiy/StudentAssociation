const Redis = require('ioredis');
const config = require('./../config');

class RedisUtil {

    constructor() {
        this.redis = new Redis(config.db.redis);
    }

    async get(key) {
        let data = await this.redis.get(key);
        if (data) {
            data = JSON.parse(data);
        }
        return data;
    }

    async set(key, value, maxAge = config.token.expireTime) {
        try {
            if (maxAge === -1) {
                await this.redis.set(key, JSON.stringify(value));
            } else {
                await this.redis.set(key, JSON.stringify(value), 'EX', maxAge);
            }
            return true;
        } catch (e) {
            return false;
        }
    }

    async del(key) {
        return await this.redis.del(key);
    }
}

module.exports = RedisUtil;