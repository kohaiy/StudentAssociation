const BaseService = require('./BaseService');
const Notice = require('../model/notice');
const User = require('../model/user');

class NoticeService extends BaseService {
    /**
     * 获取用户所在同乡会的所有公告
     * @param {String} uid 用户 id
     */
    static async getNotices(uid, all) {
        const user = await User.findById(uid, 'association');
        let query = { association: user.association };
        if(!all) {
            query.status = true;
        }
        const notices = await Notice
            .find(query)
            .populate('user', 'username')
            .sort('-createTime');
        return this.success(notices);
    }
    /**
     * 创建公告
     * @param {String} uid 用户 id
     * @param {String} content 公告内容
     * @param {[String]} images 公告图片内容
     */
    static async createNotice(uid, content, images) {
        // 获取用户
        const user = await User.findById(uid, 'username').populate('association');
        // 判断其是否是同乡会管理员
        if (user.association
            && (user.association.chairman.toString() === uid
                || this.getIndex(user.association.managers, uid) > -1)) {
            let notice = new Notice({
                user,
                association: user.association,
                content,
                images,
                createTime: Date.now(),
            });
            const error = this.validate(notice);
            if (error) {
                return error;
            }
            notice = await notice.save();
            return this.success(notice);
        } else {
            return this.failure('权限不足：只有同乡会会长或管理员可以发布公告。');
        }
    }

    /**
     * 删除一条公告
     * @param {String} uid 用户 id
     * @param {String} _id 公告 id
     */
    static async removeNotice(uid, _id) {
        const user = await User.findById(uid).populate('association');
        // 判断其是否是同乡会管理员
        if (user.association
            && (user.association.chairman.toString() === uid
                || this.getIndex(user.association.managers, uid) > -1)) {
            const notice = await Notice.findOneAndRemove({ _id });
            return this.success(notice);
        } else {
            return this.failure('权限不足：只有同乡会会长或管理员可以删除公告。');
        }
    }

    static async updateNotice(uid, _id, status) {
        const user = await User.findById(uid).populate('association');
        // 判断其是否是同乡会管理员
        if (user.association
            && (user.association.chairman.toString() === uid
                || this.getIndex(user.association.managers, uid) > -1)) {
            const notice = await Notice.findById(_id);
            notice.status = !!status;
            await notice.save();
            return this.success(notice);
        } else {
            return this.failure('权限不足：只有同乡会会长或管理员可以删除公告。');
        }
    }
}

module.exports = NoticeService;