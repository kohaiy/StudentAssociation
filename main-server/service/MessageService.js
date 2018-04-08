const BaseService = require('./BaseService');
const Message = require('../model/message');
const User = require('../model/user');

class MessageService extends BaseService {

    static async getMessagesByUid(receiver) {
        const messages = await Message.find({ receiver }).populate('sender');
        return this.success(messages);
    }

    /**
     * 获取系统通知消息
     * @param receiver 接收者 id
     * @param offset 偏移量
     * @param quantity 获取数量
     * @returns {Promise<{status: number, code: number, message: string, data: {}}>}
     */
    static async getSystemMessages(receiver, { offset = 0, quantity = 1 } = {}) {
        const messages = await Message.find({
            receiver,
            sender: null,
        }).skip(+offset).limit(+quantity).sort('-createTime');
        await Message.update({ receiver, sender: null }, { $set: { status: true } }, { multi: true });
        return this.success(messages);
    }

    /**
     * 获取私密消息
     * @param receiver 接收者
     * @param sender 发送者
     * @returns {Promise<{status: number, code: number, message: string, data: {}}>}
     */
    static async getWhisperMessages(receiver, sender, { offset = 0, quantity = 10 } = {}) {
        console.log(offset);
        const messages = await Message.find()
            .or([{ receiver, sender }, { receiver: sender, sender: receiver }])
            .sort('-createTime').skip(+offset).limit(+quantity);
        console.log(messages);
        await Message.update({
            receiver,
            sender: { $ne: null },
            status: false,
        }, { $set: { status: true } }, { multi: true });
        return this.success(messages);
    }

    /**
     * 获取聊天的用户列表
     * @param _id
     * @returns {Promise<{status: number, code: number, message: string, data: {}}>}
     */
    static async getMemberList(_id) {
        let list = await Message.find({ sender: { $ne: null } })
            .or([{ receiver: _id }, { sender: _id }])
            .select('receiver sender').sort('-createTime');
        let set = new Set();
        list.map((l) => {
            if (l.receiver && l.receiver.toString() !== _id)
                set.add(l.receiver.toString());
            if (l.sender && l.sender.toString() !== _id)
                set.add(l.sender.toString());
        });
        list = [];
        set = [...set];
        for (let i in set) {
            list.push(await User.findById(set[i], 'username'));
        }
        for (let i in set) {
            list[i]._doc.unread = await Message.find({ sender: set[i], receiver: _id, status: false }).count();
        }
        return this.success(list);
    }

    /**
     * 创建系统消息
     * @param receiver
     * @param content
     * @param title
     * @returns {Promise<*>}
     */
    static async createSystemMessage(receiver, content, title) {
        if (!title && content) {
            title = content.slice(0, Math.min(50, content.length));
        }
        let message = new Message({
            receiver,
            title,
            content,
            createTime: Date.now(),
        });
        const error = this.validate(message);
        if (error) {
            return error;
        }
        message = await message.save();
        return this.success(message);
    }

    /**
     * 创建私密消息
     * @param receiver
     * @param content
     * @param sender
     * @returns {Promise<*>}
     */
    static async createWhisperMessage(receiver, content, sender) {
        let message = new Message({
            receiver,
            sender,
            content,
            createTime: Date.now(),
        });
        const error = this.validate(message);
        if (error) {
            return error;
        }
        message = await message.save();
        return this.success(message);
    }

    /**
     * 获取未读消息数量
     * @returns {Promise<{status: number, code: number, message: string, data: {}}>}
     * @param receiver
     */
    static async getUnreadMessagesQuantity(receiver) {
        let allUnreadMessages = await Message.find({ receiver, status: false }) || [];
        let systemUM = allUnreadMessages.filter(msg => msg.sender === null) || [];
        let whisperUM = allUnreadMessages.length - systemUM.length;
        return this.success({
            all: allUnreadMessages.length,
            system: systemUM.length,
            whisper: whisperUM,
        });
    }

    /**
     * 设置消息为已读
     * @param _id
     * @returns {Promise<{status: number, code: number, message: string, data: {}}>}
     */
    static async readMessage(_id) {
        const message = await Message.findById(_id);
        message.status = true;
        await message.save();
        return this.success();
    }

    /**
     * 群发消息
     * @param uid 群发人
     * @param content 内容
     * @returns {Promise.<*>}
     */
    static async massMessage(uid, content) {
        const user = await User.findById(uid).populate('association');
        // 判断当前用户是否为管理员
        if (uid === user.association.chairman.toString()
            || this.getIndex(user.association.managers, uid) > -1) {
            const users = await User.find({ association: user.association._id }) || [];
            // console.log(users);
            for (let i in users) {
                let result = await this.createSystemMessage(users[i],
                    `${user.username}： ${content}`,
                    `【${user.association.name}】通知`);
                console.log(result);
            }
            return this.success();
        } else {
            return this.failure('权限不足：只有会长和管理员可以群发信息', 400);
        }
    }

    /**
     * 设置所有消息为已读
     * @param receiver
     * @returns {Promise<{status: number, code: number, message: string, data: {}}>}
     */
    static async readAllMessages(receiver) {
        await Message.findAndUpdate({ receiver }, { $set: { status: true } });
        return this.success();
    }

    static async removeMessage(_id) {
        await Message.findOneAndRemove({ _id });
        return this.success();
    }

    static async removeAllMessage(receiver) {
        // todo is it has findAndRemove function on mongoose
        await Message.findAndRemove({ receiver });
        return this.success();
    }

}

module.exports = MessageService;
