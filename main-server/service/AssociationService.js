const BaseService = require('./BaseService');
const Association = require('../model/association');
const User = require('../model/user');

class AssociationService extends BaseService {
    static async getAssociationsBySchoolId(schoolId) {
        let associations = await Association.find({ school: schoolId });
        return this.success(associations);
    }

    static async getById(_id, opts) {
        let association = Association.findById(_id);
        for (let key in opts) {
            if (key !== 'chairman' && key !== 'managers') {
                association = association.populate(key);
            } else {
                association = association.populate({
                    path: key,
                    select: '-password -realName',
                });
            }
        }
        association = await association;
        // if (opts['chairman']) {
        //     association.chairman = await User.getPublicInfoById(association.chairman);
        // }
        return this.success(association);
    }

    static async createAssociation(uid, name, city, description) {
        const user = await User.findById(uid);
        if (!user.school || user.association) {
            return this.failure('出了未知错误！');
        }
        let association = new Association({
            name,
            city,
            description,
            chairman: user._id,
            school: user.school,
        });
        const error = this.validate(association);
        if (error) {
            return error;
        }
        association = await association.save();
        user.association = association._id;
        await user.save();
        return this.success(association);
    }
}

module.exports = AssociationService;