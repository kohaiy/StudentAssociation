module.exports = () => {
    function json(data) {
        if (data.hasOwnProperty('code') && typeof data.code === 'number') {
            this.response.status = data.code;
        }
        this.set('Content-Type', 'application/json;charset=utf-8');
        this.body = JSON.stringify(data);
    }

    return async (ctx, next) => {
        ctx.json = json.bind(ctx);
        await next();
    };
};