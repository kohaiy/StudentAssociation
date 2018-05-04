const BaseController = require('./BaseController');
const AssociationService = require('../service/AssociationService');
const SessionService = require('../service/SessionService');

class AssociationController extends BaseController {
    static async createAssociation(ctx) {
        const token = ctx.header.authorization;
        let result = await SessionService.validateToken(token);
        if (result.status === 0) {
            const { name, city, description } = ctx.request.body;
            result = await AssociationService.createAssociation(result.data._id, name, city, description);
        }
        ctx.json(result);
    }

    static async getBySchool(ctx) {
        const schoolId = ctx.params.school;
        ctx.json(await AssociationService.getAssociationsBySchoolId(schoolId));
    }

    static async getById(ctx) {
        // ctx.json(await AssociationService.getById(ctx.params.id, ctx.request.query));
        const token = ctx.header.authorization;
        let result = await SessionService.validateToken(token);
        if (result.status === 0) {
            result = await AssociationService.getById(result.data._id, ctx.request.query)
        }
        ctx.json(result);
    }

    static async getMembers(ctx) {
        const token = ctx.header.authorization;
        let result = await SessionService.validateToken(token);
        if (result.status === 0) {
            result = await AssociationService.getMembersByAid(result.data._id);
        }
        ctx.json(result);
    }

    static async update(ctx) {
        const token = ctx.header.authorization;
        let result = await SessionService.validateToken(token);
        if (result.status === 0) {
            // 设置管理员、取消设置管理员、重设会长、踢除会员
            let actions = ['setMemberToManager', 'setManagerToMember', 'resetChairman', 'setMemberOut'];
            if (ctx.request.query.action === 'info') {
                result = await AssociationService.updateInfo(result.data._id, ctx.request.body);
            } else if (actions.indexOf(ctx.request.query.action) > -1) {
                result = await
                    AssociationService[ctx.request.query.action](result.data._id, ctx.request.body.id);
            }
            ctx.json(result);
        }

    }
}

module.exports = AssociationController;